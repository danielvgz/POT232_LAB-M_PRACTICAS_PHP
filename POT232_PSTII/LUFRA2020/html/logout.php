<?php
session_start();
// Vacía y destruye la sesión de forma segura
$_SESSION = [];
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params['path'], $params['domain'],
        $params['secure'], $params['httponly']
    );
}
session_destroy();

// Redirige a la página principal. Ajusta la ruta si es necesario.
header('Location: ../../index.php');
exit;
