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
            $usuario = trim($_POST['usuario'] ?? '');
            $password = $_POST['password'] ?? '';
            $user = $this->usuarioModel->Login($usuario, $password);

            if ($user) {
                $_SESSION['usuario_id'] = $user->__GET('id');
                $_SESSION['usuario_username'] = $user->__GET('username');
                $_SESSION['usuario_correo'] = $user->__GET('correo');
                $_SESSION['usuario_rol'] = $user->__GET('rol');
                header('Location: index.php?c=Alumno');
                exit;
            }

            $error = 'Usuario o contraseña incorrectos.';
        }

        require_once 'views/header.php';
        include __DIR__ . '/../views/login.php';
        require_once 'views/footer.php';
    }

    public function register() {
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['nuevo_usuario'] ?? '');
            $correo = trim($_POST['nuevo_correo'] ?? '');
            $password = $_POST['nuevo_password'] ?? '';
            $passwordConfirmacion = $_POST['nuevo_password_confirmacion'] ?? '';

            if ($username === '' || $correo === '' || $password === '') {
                $error = 'Todos los campos de registro son obligatorios.';
            } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                $error = 'Debe ingresar un correo válido.';
            } elseif (strlen($password) < 8) {
                $error = 'La contraseña debe tener al menos 8 caracteres.';
            } elseif ($password !== $passwordConfirmacion) {
                $error = 'La confirmación de contraseña no coincide.';
            } elseif ($this->usuarioModel->ExistePorUsuarioOCorreo($username, $correo)) {
                $error = 'El usuario o correo ya está registrado.';
            } else {
                $this->usuarioModel->RegistrarAlumno($username, $correo, $password);
                $success = 'Registro exitoso. Ahora puede iniciar sesión como alumno.';
            }
        }

        require_once 'views/header.php';
        include __DIR__ . '/../views/login.php';
        require_once 'views/footer.php';
    }

    public function asignarProfesor() {
        if (empty($_SESSION['usuario_id']) || ($_SESSION['usuario_rol'] ?? '') !== 'admin') {
            header('Location: index.php?c=Alumno&msg=unauthorized');
            exit;
        }

        $idUsuario = (int)($_GET['id'] ?? 0);
        if ($idUsuario > 0) {
            $this->usuarioModel->AsignarProfesor($idUsuario);
        }

        header('Location: index.php?c=Alumno&msg=rol_actualizado');
        exit;
    }

    public function logout() {
        $_SESSION = [];
        session_destroy();
        header('Location: index.php?action=login');
        exit;
    }
}
