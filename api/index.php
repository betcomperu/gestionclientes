<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

// Obtener la ruta solicitada (compatible con ambos entornos)
$base_path = '/api/'; // Ajustar para eliminar el prefijo 'api/' correctamente

$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Ajustar el cálculo del endpoint para eliminar correctamente el prefijo
if (strpos($request_uri, $base_path) === 0) {
    $endpoint = substr($request_uri, strlen($base_path));
} else {
    $endpoint = trim($request_uri, '/');
}

// Debug (opcional)
error_log("Request URI: " . $_SERVER['REQUEST_URI']);
error_log("Endpoint: " . $endpoint);

// Depuración adicional
error_log("Base Path: " . $base_path);
error_log("Request URI: " . $request_uri);
error_log("Endpoint calculado: " . $endpoint);

try {
    require_once __DIR__ . '/controllers/ClienteApiController.php';
    $controller = new ClienteApiController();
    
    switch ($endpoint) {
        case 'clientes':
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $controller->getClientes();
            } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = json_decode(file_get_contents('php://input'), true);
                $controller->createCliente($data);
            } else {
                throw new Exception("Método no permitido", 405);
            }
            break;
            
        case (preg_match('/^clientes\\/(\\d+)$/', $endpoint, $matches) ? true : false):
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $controller->getClienteById($matches[1]);
            } else {
                throw new Exception("Método no permitido", 405);
            }
            break;

        default:
            throw new Exception("Ruta no encontrada", 404);
    }
} catch (Exception $e) {
    http_response_code($e->getCode() ?: 500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
        'request' => $endpoint
    ]);
}
?>