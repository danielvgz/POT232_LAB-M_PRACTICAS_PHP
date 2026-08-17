<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// ... rest of your code ...
// Controlador de login/logout
require_once 'controllers/auth.controller.php';

$action = $_GET['action'] ?? '';
define( 'RUTA_HTTP', 'https://' . $_SERVER['HTTP_HOST'] . '/Alumnos-Crud/' );
// Si la acción es login/logout/registro, gestiona el acceso sin requerir autenticación del usuario
if ($action === 'login') {
    $auth = new AuthController();
    $auth->login();
    exit;
}
if ($action === 'register') {
    $auth = new AuthController();
    $auth->register();
    exit;
}
if ($action === 'logout') {
    $auth = new AuthController();
    $auth->logout();
    exit;
}
if ($action === 'asignar_profesor') {
    require_once 'auth.php';
    $auth = new AuthController();
    $auth->asignarProfesor();
    exit;
}

// Protege todo lo demás
require_once 'auth.php';

// Esta lógica hará el papel de FrontController
if(!isset($_REQUEST['c'])){
    require_once 'controllers/alumno.controller.php';
    $controller = new AlumnoController();
    $controller->Index();    
} else {
    // Obtenemos el controlador que queremos cargar
    $controllerBase = preg_replace('/[^a-zA-Z0-9_]/', '', $_REQUEST['c']);
    $controller = $controllerBase . 'Controller';
    $accion     = isset($_REQUEST['a']) ? $_REQUEST['a'] : 'Index';
    $controllerFile = 'controllers/' . strtolower($controllerBase) . '.controller.php';

    if (!is_file($controllerFile)) {
        header('HTTP/1.1 404 Not Found');
        echo 'Controlador no encontrado.';
        exit;
    }

    require_once $controllerFile;

    // Instanciamos el controlador
    $controller = new $controller();

    // Llama la acción
    call_user_func( array( $controller, $accion ) );
}
