<?php

// Autoload function to load controllers and models automatically
spl_autoload_register(function ($class_name) {
    $folders = ['controllers', 'models'];
    foreach ($folders as $folder) {
        $file = __DIR__ . "/../app/{$folder}/{$class_name}.php";
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Definition of routes for the system
$system_routes = [
    '/' => 'ClienteController@index',
    '/create' => 'ClienteController@create',
    '/login' => 'LoginController@login',
    '/logout' => 'LoginController@logout',
    '/dashboard' => 'DashboardController@index',
    '/store' => 'ClienteController@store',
    '/edit/{id}' => 'ClienteController@edit',
    '/update/{id}' => 'ClienteController@update',
    '/show/{id}' => 'ClienteController@show',
    '/delete/{id}' => 'ClienteController@delete',
];

// Function to dispatch routes with dynamic parameters
function dispatch($url, $routes, $method) {
    if (!is_array($routes) || empty($routes)) {
        http_response_code(404);
        echo json_encode(['error' => 'No se encontraron rutas para este método']);
        return;
    }

    // Depuración: Imprimir URL y método
    error_log("URL: $url, Método: $method");

    $urlParts = explode('/', trim($url, '/'));
    foreach ($routes as $route => $action) {
        $routeParts = explode('/', trim($route, '/'));
        $params = [];
        if (count($urlParts) === count($routeParts)) {
            foreach ($routeParts as $i => $part) {
                if (strpos($part, '{') === 0 && strpos($part, '}') === strlen($part) - 1) {
                    $params[substr($part, 1, -1)] = $urlParts[$i];
                } elseif ($part !== $urlParts[$i]) {
                    continue 2;
                }
            }
            list($controller, $methodName) = explode('@', $action);
            $controllerInstance = new $controller;
            if (method_exists($controllerInstance, $methodName)) {
                
                // Asegurar que los parámetros sean un array indexado
                $params = array_values($params);
                
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $params[] = $_POST; // Agrega los datos de POST como último parámetro
                }
                
                call_user_func_array([$controllerInstance, $methodName], $params);
                return; // Asegura que la función termine después de manejar una ruta
            } else {
                http_response_code(500);
                echo json_encode(['error' => "Método $methodName no encontrado en el controlador $controller"]);
                return;
            }
        }
    }
    http_response_code(404);
    echo json_encode(['error' => 'Ruta no encontrada']);
}
