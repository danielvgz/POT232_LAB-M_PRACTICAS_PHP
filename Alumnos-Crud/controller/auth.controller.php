<?php
require_once __DIR__ . '/../model/usuario.model.php';
require_once __DIR__ . '/../model/usuario.entidad.php';
session_start();

class AuthController {
    private $usuarioModel;
    public function __CONSTRUCT() {
        $this->usuarioModel = new UsuarioModel();
    }
    public function login() {
        $error = '';
        if (isset($_SESSION['usuario_correo'])) {
            header('Location: index.php');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $correo = $_POST['correo'] ?? '';
            $password = $_POST['password'] ?? '';
            $user = $this->usuarioModel->Login($correo, $password);
            if ($user) {
                $_SESSION['usuario_id'] = $user->__GET('id');
                $_SESSION['usuario_correo'] = $user->__GET('correo');
                header('Location: index.php');
                exit;
            } else {
                $error = 'Correo o contraseña incorrectos.';
            }
        }
        include __DIR__ . '/../view/login.php';
    }
    public function logout() {
        session_destroy();
        header('Location: index.php?action=login');
        exit;
    }
}
