<?php
require_once __DIR__ . '/../models/ClienteModel.php';

class LoginController {
    private $model;

    public function __construct() {
        // Inicializa el modelo de cliente
        $this->model = new ClienteModel();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = $_POST['usuario'] ?? '';
            $clave = $_POST['clave'] ?? '';

            if (empty($usuario) || empty($clave)) {
                $error = "Por favor, ingresa tu usuario y contraseña.";
            } else {
                $cliente = $this->model->autenticar($usuario, $clave);

           /*    var_dump($cliente); // <-- Aquí Beto
                exit() ;*/

                if ($cliente) {
                    session_start();
                    $_SESSION['id'] = $cliente['id'];
                    $_SESSION['nombre'] = $cliente['nombre'];
                    $_SESSION['apellido'] = $cliente['apellido'];
                    $_SESSION['correo'] = $cliente['correo'];
                    $_SESSION['ciudad'] = $cliente['ciudad'];
                    $_SESSION['fecha_nacimiento'] = $cliente['fecha_nacimiento'];
                    $_SESSION['usuario'] = $cliente['usuario'];
                    $_SESSION['foto'] = $cliente['foto'];

                    // header('Location: /dashboard');
                    // exit;
                    header('Location: http://gestionclientes.com/dashboard');
                    exit;

                } else {
                    $error = "Usuario o contraseña incorrectos.";
                }
            }
        }

        $titulo = 'Iniciar Sesión';
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/login/index.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start(); // Inicia la sesión solo si no está activa
        }

        session_unset();
        session_destroy();
        header('Location: /login');
        exit;
    }
}
?>