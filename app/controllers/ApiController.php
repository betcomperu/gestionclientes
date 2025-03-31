<?php
class ApiController {
    private $model;

    public function __construct() {
        $this->model = new ClienteModel();
    }

    // Obtener todos los clientes
    public function obtenerClientes() {
        $clientes = $this->model->obtenerTodos();

        header('Content-Type: application/json');
        echo json_encode($clientes);
    }

    // Obtener un cliente por ID
    public function obtenerClientePorId($id) {
        $cliente = $this->model->obtenerPorId($id);

        if ($cliente) {
            header('Content-Type: application/json');
            echo json_encode($cliente);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Cliente no encontrado']);
        }
    }

    // Crear un nuevo cliente
    public function crearCliente() {
        $data = json_decode(file_get_contents('php://input'), true);

        if (empty($data['nombre']) || empty($data['usuario']) || empty($data['clave'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Datos incompletos']);
            return;
        }

        $data['clave'] = password_hash($data['clave'], PASSWORD_BCRYPT);
        $resultado = $this->model->insertar($data);

        if ($resultado) {
            http_response_code(201);
            echo json_encode(['mensaje' => 'Cliente creado exitosamente']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Error al crear el cliente']);
        }
    }

    // Actualizar un cliente
    public function actualizarCliente($id) {
        $data = json_decode(file_get_contents('php://input'), true);

        $cliente = $this->model->obtenerPorId($id);
        if (!$cliente) {
            http_response_code(404);
            echo json_encode(['error' => 'Cliente no encontrado']);
            return;
        }

        if (!empty($data['clave'])) {
            $data['clave'] = password_hash($data['clave'], PASSWORD_BCRYPT);
        }

        $resultado = $this->model->actualizar($id, $data);

        if ($resultado) {
            http_response_code(200);
            echo json_encode(['mensaje' => 'Cliente actualizado exitosamente']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Error al actualizar el cliente']);
        }
    }

    // Eliminar un cliente
    public function eliminarCliente($id) {
        $cliente = $this->model->obtenerPorId($id);
        if (!$cliente) {
            http_response_code(404);
            echo json_encode(['error' => 'Cliente no encontrado']);
            return;
        }

        $resultado = $this->model->eliminar($id);

        if ($resultado) {
            http_response_code(200);
            echo json_encode(['mensaje' => 'Cliente eliminado exitosamente']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Error al eliminar el cliente']);
        }
    }
}