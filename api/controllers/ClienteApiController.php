<?php
require_once __DIR__ . '/../../app/models/ClienteModel.php'; // Importar el modelo ClienteModel

class ClienteApiController {
    private $model;

    public function __construct() {
        $this->model = new ClienteModel();
    }

    public function getClientes() {
        header('Content-Type: application/json');
        
        try {
            $clientes = $this->model->obtenerTodos();

            // Filtrar los campos requeridos
            $clientesFiltrados = array_map(function($cliente) {
                return [
                    'nombre' => $cliente['nombre'],
                    'apellido' => $cliente['apellido'],
                    'correo' => $cliente['correo'],
                    'ciudad' => $cliente['ciudad'],
                    'fecha_nacimiento' => $cliente['fecha_nacimiento'],
                    'foto' => $cliente['foto']
                ];
            }, $clientes);
            
            echo json_encode([
                'success' => true,
                'data' => $clientesFiltrados,
                'count' => count($clientesFiltrados)
            ]);
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function getClienteById($id) {
        header('Content-Type: application/json');

        try {
            $cliente = $this->model->obtenerPorId($id);

            if (!$cliente) {
                http_response_code(404);
                echo json_encode([
                    'success' => false,
                    'error' => 'Cliente no encontrado'
                ]);
                return;
            }

            // Filtrar los campos requeridos
            $clienteFiltrado = [
                'nombre' => $cliente->nombre,
                'apellido' => $cliente->apellido,
                'correo' => $cliente->correo,
                'ciudad' => $cliente->ciudad,
                'fecha_nacimiento' => $cliente->fecha_nacimiento,
                'foto' => $cliente->foto
            ];

            echo json_encode([
                'success' => true,
                'data' => $clienteFiltrado
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function createCliente($data) {
        try {
            // Depuración: Verificar los datos recibidos
            error_log("Datos recibidos: " . json_encode($data));

            // Validación básica
            if (empty($data['nombre']) || empty($data['correo']) || empty($data['apellido']) || empty($data['ciudad']) || empty($data['fecha_nacimiento'])) {
                throw new Exception("Datos incompletos", 400);
            }
            
            // Validar el campo 'clave'
            if (empty($data['clave'])) {
                throw new Exception("El campo 'clave' es obligatorio", 400);
            }
            
            // Validar el campo 'usuario'
            if (empty($data['usuario'])) {
                throw new Exception("El campo 'usuario' es obligatorio", 400);
            }
            
            // Si no se proporciona el campo 'foto', configurarlo como NULL
            if (!isset($data['foto']) || empty($data['foto'])) {
                $data['foto'] = null;
            }
            
            $result = $this->model->insertar($data);
            
            echo json_encode([
                'success' => true,
                'message' => 'Cliente creado',
                'id' => $result
            ]);
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => "Error al crear cliente: " . $e->getMessage()
            ]);
        }
    }
}
?>