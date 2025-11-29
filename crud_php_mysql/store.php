<?php
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}


$nombre = trim($_POST['nombre'] ?? '');
$cedula = trim($_POST['cedula'] ?? '');
$fecha_nacimiento = trim($_POST['fecha_nacimiento'] ?? '');
$edad = isset($_POST['edad']) ? (int)$_POST['edad'] : null;

// Validación básica del lado servidor
if ($nombre === '' || strlen($nombre) > 10) {
    header('Location: create.php?msg=' . urlencode('Nombre inválido'));
    exit;
}
// Nombre: sólo letras y espacios (permitir acentos)
if (!preg_match('/^[A-Za-zÀ-ÿ\s]+$/u', $nombre)) {
    header('Location: create.php?msg=' . urlencode('Nombre: solo letras y espacios'));
    exit;
}
if ($cedula === '' || strlen($cedula) > 10) {
    header('Location: create.php?msg=' . urlencode('Cédula inválida'));
    exit;
}
// Cédula: una letra, opcional '-', luego solo dígitos
if (!preg_match('/^[A-Za-z]-?\d+$/', $cedula)) {
    header('Location: create.php?msg=' . urlencode('Cédula: formato inválido'));
    exit;
}
if ($fecha_nacimiento === '') {
    header('Location: create.php?msg=' . urlencode('Fecha de nacimiento obligatoria'));
    exit;
}
if (!is_int($edad) && !is_numeric($edad)) {
    header('Location: create.php?msg=' . urlencode('Edad inválida'));
    exit;
}
$edad = (int)$edad;
if ($edad < 0 || $edad > 99) {
    header('Location: create.php?msg=' . urlencode('Edad fuera de rango'));
    exit;
}

$st = $pdo->prepare('INSERT INTO users (nombre, cedula, fecha_nacimiento, edad) VALUES (?, ?, ?, ?)');
$st->execute([$nombre, $cedula, $fecha_nacimiento, $edad]);

header('Location: index.php?msg=' . urlencode('Usuario creado correctamente'));
exit;
