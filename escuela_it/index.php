<?php
session_start();

define('BASE_PATH', __DIR__);
define('BASE_URL', rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\'));

$controllerName = isset($_GET['controller']) ? strtolower($_GET['controller']) : (isset($_SESSION['user']) ? 'home' : 'auth');
$action = isset($_GET['action']) ? $_GET['action'] : (isset($_SESSION['user']) ? 'index' : 'login');

$publicRoutes = array('auth');
if (!isset($_SESSION['user']) && !in_array($controllerName, $publicRoutes, true)) {
    header('Location: index.php?controller=auth&action=login');
    exit;
}

$controllerMap = array(
    'auth' => 'AuthController',
    'home' => 'HomeController',
    'alumnos' => 'AlumnosController',
    'docentes' => 'DocentesController',
    'materias' => 'MateriasController',
    'matriculas' => 'MatriculasController',
);

if (!isset($controllerMap[$controllerName])) {
    http_response_code(404);
    echo 'Controlador no encontrado';
    exit;
}

require_once BASE_PATH . '/controllers/' . $controllerMap[$controllerName] . '.php';
$controller = new $controllerMap[$controllerName]();

if (!method_exists($controller, $action)) {
    http_response_code(404);
    echo 'Acción no encontrada';
    exit;
}

$controller->$action();
