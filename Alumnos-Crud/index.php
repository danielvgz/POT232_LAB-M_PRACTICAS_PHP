<?php
// Controlador de login/logout
require_once 'controllers/auth.controller.php';

$action = $_GET['action'] ?? '';

// Si la acción es login o logout, gestiona el acceso sin requerir autenticación del usuario
if ($action === 'login') {
    $auth = new AuthController();
    $auth->login();
    exit;
}
if ($action === 'logout') {
    $auth = new AuthController();
    $auth->logout();
    exit;
}

// Protege todo lo demás
require_once 'auth.php';

// FrontController original:
require_once 'controller/alumno.controller.php';
// Ruta del proyecto, cámbiala por la ruta que vas a usar

// Esta lógica hará el papel de FrontController
if(!isset($_REQUEST['c'])){
    $controller = new AlumnoController();
    $controller->Index();    
} else {
    // Obtenemos el controlador que queremos cargar
    $controller = $_REQUEST['c'] . 'Controller';
    $accion     = isset($_REQUEST['a']) ? $_REQUEST['a'] : 'Index';

    // Instanciamos el controlador
    $controller = new $controller();

    // Llama la acción
    call_user_func( array( $controller, $accion ) );
}
