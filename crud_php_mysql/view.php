<?php
require_once 'db_connect.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$st = $pdo->prepare('SELECT * FROM personas WHERE id = ?');
$st->execute([$id]);
$user = $st->fetch();
if (!$user) {
    header('Location: index.php?msg=' . urlencode('Usuario no encontrado'));
    exit;
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Ver Usuario</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
  <h1 class="h3 mb-3">Detalles del Usuario</h1>
  <dl class="row">
    <dt class="col-sm-3">ID</dt><dd class="col-sm-9"><?php echo $user['id']; ?></dd>
    <dt class="col-sm-3">Nombre</dt><dd class="col-sm-9"><?php echo htmlspecialchars($user['nombre']); ?></dd>
    <dt class="col-sm-3">Cédula</dt><dd class="col-sm-9"><?php echo htmlspecialchars($user['cedula'] ?? ''); ?></dd>
    <dt class="col-sm-3">Fecha de nacimiento</dt><dd class="col-sm-9"><?php echo htmlspecialchars($user['fecha_nacimiento'] ?? ''); ?></dd>
    <dt class="col-sm-3">Edad</dt><dd class="col-sm-9"><?php echo htmlspecialchars($user['edad'] ?? ''); ?></dd>
    
  </dl>
  <a href="index.php" class="btn btn-secondary">Volver</a>
  <a href="edit.php?id=<?php echo $user['id']; ?>" class="btn btn-warning">Editar</a>
</div>
</body>
</html>
