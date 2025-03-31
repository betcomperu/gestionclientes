<?php
require_once '../config/database.php';
require_once '../app/controllers/ClienteController.php';

$url = isset($_GET['url']) ? $_GET['url'] : '/';

$controller = new ClienteController();

switch ($url) {
    case '/':
        $controller->index();
        break;
    case 'create':
        $controller->create();
        break;
    case 'store':
        $controller->store($_POST);
        break;
    case 'edit':
        $controller->edit($_GET['id']);
        break;
    case 'update':
        $controller->update($_POST);
        break;
    case 'show':
        $controller->show($_GET['id']);
        break;
    case 'delete':
        $controller->delete($_GET['id']);
        break;
    default:
        echo "Página no encontrada.";
        break;
}
?>
