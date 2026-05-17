<?php
require_once __DIR__ . '/../models/usuario.model.php';
require_once __DIR__ . '/../models/usuario.entidad.php';
session_start();

class AuthController {
    private $usuarioModel;
    public function __CONSTRUCT() {
        $this->usuarioModel = new UsuarioModel();
    }
    public function login() {
    $error = '';
    if (isset($_SESSION['usuario_username'])) {
        header('Location: index.php?c=Alumno');
        exit;
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $usuario = $_POST['usuario'] ?? '';
        $password = $_POST['password'] ?? '';
        $user = $this->usuarioModel->Login($usuario, $password);
        if ($user) {
            $_SESSION['usuario_id'] = $user->__GET('id');
            $_SESSION['usuario_username'] = $user->__GET('username');
            header('Location: index.php?c=Alumno');
            exit;
        } else {
            $error = 'Usuario o contraseña incorrectos.';
        }
    }
   
	require_once 'views/header.php';
        include __DIR__ . '/../views/login.php';
	require_once 'views/footer.php';
    }
    public function logout() {
        session_destroy();
        header('Location: index.php?action=login');
        exit;
    }
}
