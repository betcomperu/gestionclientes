<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Inicia la sesión solo si no está activa
}

// Autoload Composer si lo usas
require_once __DIR__ . '/../vendor/autoload.php';

// Cargas necesarias
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/controllers/ClienteController.php';
require_once __DIR__ . '/../app/controllers/HomeController.php';
require_once __DIR__ . '/../app/controllers/LoginController.php';
require_once __DIR__ . '/../app/controllers/DashboardController.php';
require_once __DIR__ . '/../config/router.php';

// Obtener la URL solicitada
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '/';
$request_method = $_SERVER['REQUEST_METHOD'];

// Depuración opcional
// var_dump($url, $request_method);

// Ejecutar el router
try {
    dispatch($url, $system_routes, $request_method);
} catch (Exception $e) {
    http_response_code(404);
    echo "Error: " . $e->getMessage();
}
?>