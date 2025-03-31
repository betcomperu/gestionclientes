<?php
class ClienteApiController {
    private $model;

    public function __construct() {
        $this->model = new ClienteModel();
    }

    public function getClientes() {
        header('Content-Type: application/json');
        
        try {
            // Cambiamos getAllClientes() por obtenerTodos()
            $clientes = $this->model->obtenerTodos();
            
            echo json_encode([
                'success' => true,
                'data' => $clientes,
                'count' => count($clientes)
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
            // Validación básica
            if (empty($data['nombre']) || empty($data['email'])) {
                throw new Exception("Datos incompletos", 400);
            }
            
            $result = $this->model->insertCliente($data);
            
            echo json_encode([
                'success' => true,
                'message' => 'Cliente creado',
                'id' => $result
            ]);
            
        } catch (Exception $e) {
            throw new Exception("Error al crear cliente: " . $e->getMessage());
        }
    }
}
?>