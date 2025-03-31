<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

// Obtener la ruta solicitada (compatible con ambos entornos)
$base_path = strpos($_SERVER['REQUEST_URI'], '/gestionclientes') !== false 
    ? '/gestionclientes/api/' 
    : '/api/';

$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$endpoint = str_replace($base_path, '', trim($request_uri, '/'));

// Debug (opcional)
error_log("Request URI: " . $_SERVER['REQUEST_URI']);
error_log("Endpoint: " . $endpoint);

try {
    require_once __DIR__ . '/controllers/ClienteApiController.php';
    $controller = new ClienteApiController();
    
    switch ($endpoint) {
        case 'clientes':
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $controller->getClientes();
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