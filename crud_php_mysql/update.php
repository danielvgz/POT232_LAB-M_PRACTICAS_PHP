<?php
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$nombre = trim($_POST['nombre'] ?? '');
$email = trim($_POST['email'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$cedula = trim($_POST['cedula'] ?? '');
$fecha_nacimiento = trim($_POST['fecha_nacimiento'] ?? '');

if ($id <= 0 || $nombre === '' || $email === '') {
    header('Location: edit.php?id=' . $id . '&msg=' . urlencode('Datos inválidos'));
    exit;
}

$st = $pdo->prepare('UPDATE users SET nombre = ?, email = ?, telefono = ?, cedula = ?, fecha_nacimiento = ? WHERE id = ?');
$st->execute([$nombre, $email, $telefono, $cedula, $fecha_nacimiento, $id]);

header('Location: index.php?msg=' . urlencode('Usuario actualizado correctamente'));
exit;
