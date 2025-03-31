<?php
// Importa el modelo ClienteModel, que se utilizará para interactuar con la base de datos
require_once __DIR__ . '/../models/ClienteModel.php';

class ClienteController
{
    private $model; // Instancia del modelo ClienteModel
    private $id; // Variable para almacenar el ID del cliente
    private $clienteModel;

    // Constructor del controlador
    public function __construct()
    {
        // Inicializa la instancia del modelo
        $this->model = new ClienteModel();
        require_once 'C:/wamp64/www/gestionclientes/app/models/ClienteModel.php'; // Ajusta la ruta según tu proyecto
       
    }

    // Método para mostrar la lista de clientes
    public function index()
    {
        // Obtiene todos los clientes del modelo
        $clientes = $this->model->obtenerTodos();
        // Datos que se pasarán a la vista
        $data = [
            'titulo' => 'Lista de Clientes',
            'clientes' => $clientes
        ];
        // Llama al método render para mostrar la vista de lista de clientes
        $this->render('clientes/index', $data);
    }

    // Método para mostrar el formulario de creación de un cliente
    public function create()
    {
        // Datos que se pasarán a la vista
        $data = [
            'titulo' => 'Crear Cliente',
            'cliente' => [] // Pasar un cliente vacío para evitar errores
        ];
        // Llama al método render para mostrar el formulario de creación
        $this->render('clientes/create', $data);
    }

        
    // Método privado para validar y subir imágenes
    private function manejarImagen($archivo, $directorio, $formatosPermitidos = ['jpg', 'png', 'jpeg'], $tamanoMaximo = 5000000)
    {
        if (empty($archivo['name'])) {
            throw new Exception("Error: No se seleccionó ningún archivo.");
        }
    
        // Verifica si el archivo es una imagen válida
        $check = getimagesize($archivo['tmp_name']);
        if ($check === false) {
            throw new Exception("Error: El archivo no es una imagen válida.");
        }
    
        // Verifica el tamaño del archivo
        if ($archivo['size'] > $tamanoMaximo) {
            throw new Exception("Error: El tamaño del archivo es demasiado grande.");
        }
    
        // Verifica el formato del archivo
        $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, $formatosPermitidos)) {
            throw new Exception("Error: Solo se permiten archivos " . implode(', ', $formatosPermitidos) . ".");
        }
    
        // Asegura que el directorio existe
        if (!is_dir($directorio)) {
            mkdir($directorio, 0775, true);
        }
    
        // Genera un nombre único para el archivo
        $nombreArchivo = time() . '_' . basename($archivo['name']);
        $rutaDestino = $directorio . $nombreArchivo;
    
        // Mueve el archivo al directorio de destino
        if (!move_uploaded_file($archivo['tmp_name'], $rutaDestino)) {
            throw new Exception("Error al mover el archivo. Verifica permisos.");
        }
    
        return $rutaDestino; // Devuelve la ruta del archivo subido
    }

    // Método para almacenar los datos del nuevo cliente
   
public function store()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $directorio = 'uploader/';
            $rutaImagen = $this->manejarImagen($_FILES['foto'], $directorio);

            $data = $_POST;
            $data['foto'] = $rutaImagen;

            if ($this->model->insertar($data)) {
                header('Location: /');
                exit();
            } else {
                throw new Exception("Error al insertar el cliente.");
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    } else {
        http_response_code(405);
        echo "Método no permitido";
    }
}
    // Método para mostrar el formulario de edición de un cliente
    public function edit($id)
{
    $cliente = $this->model->obtenerPorId($id);
    if (!$cliente) {
        echo "Cliente no encontrado.";
        header('Location: /'); // Redirige a la página principal
        exit();
    }

    $data = [
        'titulo' => 'Editar Cliente',
        'cliente' => $cliente
    ];

    $this->render('clientes/edit', $data);
}

    // Método para actualizar los datos de un cliente
    public function update($id) {
        try {
            // Verificar que el cliente existe en la base de datos
            $cliente = $this->model->obtenerPorId($id);
            if (!$cliente) {
                throw new Exception("❌ Cliente no encontrado.");
            }
    
            // Recoger datos del formulario
            $data = [
                'nombre' => trim($_POST['nombre']),
                'apellido' => trim($_POST['apellido']),
                'correo' => trim($_POST['correo']),
                'ciudad' => trim($_POST['ciudad']),
                'fecha_nacimiento' => trim($_POST['fecha_nacimiento']),
                'usuario' => trim($_POST['usuario']),
                'clave' => !empty($_POST['clave']) ? password_hash($_POST['clave'], PASSWORD_DEFAULT) : $cliente->clave,
                'foto' => $cliente->foto, // Mantener la foto original si no se sube una nueva
            ];
    
            // Directorio de subida de imágenes
            $directorio = __DIR__ . '/../../public/uploader/'; // Cambié la ruta para que apunte a la carpeta 'uploader'
            $rutaRelativa = 'uploader/'; // Cambié la ruta relativa para que apunte a 'uploader/'
    
            // Asegurar que el directorio de subida existe
            if (!is_dir($directorio)) {
                mkdir($directorio, 0775, true); // Crear carpeta con permisos adecuados
            }
    
            // Manejo de la imagen (si se sube una nueva)
            if (!empty($_FILES['foto']['name'])) {
                // Validar el tipo de archivo
                $permitidos = ['image/jpeg', 'image/png', 'image/gif'];
                if (!in_array($_FILES['foto']['type'], $permitidos)) {
                    throw new Exception("❌ Tipo de archivo no permitido.");
                }
    
                // Validar el tamaño máximo (por ejemplo, 2MB)
                $max_tamano = 2 * 1024 * 1024; // 2MB
                if ($_FILES['foto']['size'] > $max_tamano) {
                    throw new Exception("❌ El archivo es demasiado grande.");
                }
    
                // Generar un nombre único para el archivo
                $nombreArchivo = time() . '_' . basename($_FILES['foto']['name']);
                $rutaDestino = $directorio . $nombreArchivo;
    
                // Mover el archivo al directorio de destino
                if (!move_uploaded_file($_FILES['foto']['tmp_name'], $rutaDestino)) {
                    throw new Exception("❌ Error al mover el archivo. Verifica permisos.");
                }
    
                // Guardar la ruta relativa en la base de datos
                $data['foto'] = $rutaRelativa . $nombreArchivo;
            } else {
                // Si no se sube una nueva imagen, mantener la existente
                $data['foto'] = $cliente->foto;
            }
    
            // Si el usuario marcó "eliminar foto"
            if (isset($_POST['eliminar_foto']) && $_POST['eliminar_foto'] === 'on') {
                // Eliminar la foto existente del servidor
                if (!empty($cliente->foto) && file_exists(__DIR__ . '/../../public/' . $cliente->foto)) {
                    unlink(__DIR__ . '/../../public/' . $cliente->foto);
                }
                $data['foto'] = null; // Limpiar la ruta en la base de datos
            }
    
            error_log("Datos enviados al modelo: " . json_encode($data));
    
            if (!empty($_FILES['foto']['name'])) {
                error_log("Nueva imagen cargada: " . $rutaRelativa . $nombreArchivo);
            } else {
                error_log("No se cargó una nueva imagen, se mantiene la existente: " . $data['foto']);
            }
    
            // Actualizar el cliente en la base de datos
            if ($this->model->actualizar($id, $data)) {
                header("Location: /"); // Redirigir a la lista de registros
                exit;
            } else {
                throw new Exception("❌ Error al actualizar el cliente en la base de datos.");
            }
    
        } catch (Exception $e) {
            error_log($e->getMessage());
            die("❌ Se produjo un error: " . $e->getMessage());
        }
    }
    
    
 
    // Método para eliminar un cliente
    public function delete($id)
    {
        $cliente = $this->model->obtenerPorId($id);
        if (!$cliente) {
            echo "Cliente no encontrado.";
            header('Location: /'); // Redirige a la página principal
            exit();
        }
    
        $this->model->eliminar($id);
        header('Location: /');
        exit();
    }
    // Método para mostrar los detalles de un cliente
    public function show($id)
    {
        // Obtiene el cliente por su ID
        $cliente = $this->model->obtenerPorId($id);
        // Datos que se pasarán a la vista
        $data = [
            'titulo' => 'Mostrar Cliente',
            'cliente' => $cliente
        ];
        // Llama al método render para mostrar la vista de detalles del cliente
        $this->render('clientes/show', $data);
    }

    // Método privado para renderizar las vistas
    private function render($view, $data = [])
    {
        extract($data); // Extrae variables del array $data
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/' . $view . '.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
}
?>