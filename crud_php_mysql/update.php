<?php
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}


$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$nombre = trim($_POST['nombre'] ?? '');
$cedula = trim($_POST['cedula'] ?? '');
$fecha_nacimiento = trim($_POST['fecha_nacimiento'] ?? '');
$edad = isset($_POST['edad']) ? (int)$_POST['edad'] : null;

if ($id <= 0) {
    header('Location: index.php?msg=' . urlencode('ID inválido'));
    exit;
}
if ($nombre === '' || strlen($nombre) > 10) {
    header('Location: edit.php?id=' . $id . '&msg=' . urlencode('Nombre inválido'));
    exit;
}
if (!preg_match('/^[A-Za-zÀ-ÿ\s]+$/u', $nombre)) {
    header('Location: edit.php?id=' . $id . '&msg=' . urlencode('Nombre: solo letras y espacios'));
    exit;
}
if ($cedula === '' || strlen($cedula) > 10) {
    header('Location: edit.php?id=' . $id . '&msg=' . urlencode('Cédula inválida'));
    exit;
}
if (!preg_match('/^[A-Za-z]-?\d+$/', $cedula)) {
    header('Location: edit.php?id=' . $id . '&msg=' . urlencode('Cédula: formato inválido'));
    exit;
}
if ($fecha_nacimiento === '') {
    header('Location: edit.php?id=' . $id . '&msg=' . urlencode('Fecha de nacimiento obligatoria'));
    exit;
}
$edad = (int)$edad;
if ($edad < 0 || $edad > 99) {
    header('Location: edit.php?id=' . $id . '&msg=' . urlencode('Edad fuera de rango'));
    exit;
}

$st = $pdo->prepare('UPDATE users SET nombre = ?, cedula = ?, fecha_nacimiento = ?, edad = ? WHERE id = ?');
$st->execute([$nombre, $cedula, $fecha_nacimiento, $edad, $id]);

header('Location: index.php?msg=' . urlencode('Usuario actualizado correctamente'));
exit;
