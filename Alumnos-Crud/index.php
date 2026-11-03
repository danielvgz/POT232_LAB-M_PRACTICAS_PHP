<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('RUTA_HTTP', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . '/Alumnos-Crud/');

if (!isset($_SESSION['auth_user'])) {
    header('Location: login.php');
    exit;
}

require_once 'controllers/alumno.controller.php';
require_once 'controllers/DocenteController.php';

// Esta lógica hará el papel de FrontController
if(!isset($_REQUEST['c'])){
    $controller = new AlumnoController();
    $controller->Index();    
} else {
    $allowedControllers = array('Alumno', 'Docente');
    $controllerName = in_array($_REQUEST['c'], $allowedControllers, true) ? $_REQUEST['c'] : 'Alumno';
    $controller = $controllerName . 'Controller';
    $accion     = isset($_REQUEST['a']) ? $_REQUEST['a'] : 'Index';

    // Instanciamos el controlador
    $controller = new $controller();

    // Llama la acción
    if (!is_callable(array($controller, $accion))) {
        $accion = 'Index';
    }
    call_user_func(array($controller, $accion));
}
