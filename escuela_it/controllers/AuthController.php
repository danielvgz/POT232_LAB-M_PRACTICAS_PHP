<?php
require_once BASE_PATH . '/controllers/BaseCrudController.php';
require_once BASE_PATH . '/models/UserModel.php';

class AuthController extends BaseCrudController
{
    public function login()
    {
        if (isset($_SESSION['user'])) {
            header('Location: index.php?controller=home&action=index');
            exit;
        }

        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $correo = isset($_POST['correo']) ? trim($_POST['correo']) : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';

            try {
                $model = new UserModel();
                $user = $model->login($correo, $password);
                if ($user) {
                    $_SESSION['user'] = $user;
                    $this->logAction('login', 'usuarios', $correo);
                    header('Location: index.php?controller=home&action=index');
                    exit;
                }
                $error = 'Credenciales inválidas';
            } catch (Exception $e) {
                $error = 'No se pudo conectar a la base de datos.';
            }
        }

        require BASE_PATH . '/views/auth/login.php';
    }

    public function logout()
    {
        session_destroy();
        header('Location: index.php?controller=auth&action=login');
        exit;
    }
}
