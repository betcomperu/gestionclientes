<?php
class DashboardController {
    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start(); // Inicia la sesión solo si no está activa
        }

        // Verifica si el usuario está autenticado (cambié 'cliente_id' por 'id')
        if (!isset($_SESSION['id'])) {
            header('Location: /login');
            exit();
        }

        $titulo = 'Dashboard';
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/dashboard/index.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
}
