<?php
require_once '../models/docentes.model.php';
require_once '../models/docentes.entidad.php';
session_start();

$docenteModel = new DocenteModel();
$action = $_GET['action'] ?? 'listar';

switch ($action) {
    case 'eliminar':
        $docenteModel->Eliminar($_GET['id']);
        header('Location: docentes.controller.php');
        break;
    case 'editar':
        $docente = $docenteModel->Obtener($_GET['id']);
        include '../views/docentes/editar.php';
        break;
    case 'actualizar':
        $docente = new Docente($_POST['id'], $_POST['nombre'], $_POST['apellido'], $_POST['email'], $_POST['especialidad']);
        $docenteModel->Actualizar($docente);
        header('Location: docentes.controller.php');
        break;
    case 'registrar':
        $docente = new Docente(null, $_POST['nombre'], $_POST['apellido'], $_POST['email'], $_POST['especialidad']);
        $docenteModel->Registrar($docente);
        header('Location: docentes.controller.php');
        break;
    case 'nuevo':
        $docente = new Docente();
        include '../views/docentes/editar.php';
        break;
    default:
        $docentes = $docenteModel->Listar();
        include '../views/docentes/index.php';
        break;
}
