<?php
require_once 'db_connect.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$st = $pdo->prepare('SELECT * FROM users WHERE id = ?');
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
  <title>Editar Usuario</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
  <h1 class="h3 mb-3">Editar Usuario</h1>
  <form action="update.php" method="post">
    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
    <div class="mb-3">
      <label class="form-label">Nombre</label>
      <input type="text" name="nombre" class="form-control" required value="<?php echo htmlspecialchars($user['nombre']); ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Email</label>
      <input type="email" name="email" class="form-control" required value="<?php echo htmlspecialchars($user['email']); ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Cédula</label>
      <input type="text" name="cedula" class="form-control" value="<?php echo htmlspecialchars($user['cedula'] ?? ''); ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Fecha de nacimiento</label>
      <input type="date" name="fecha_nacimiento" class="form-control" value="<?php echo htmlspecialchars($user['fecha_nacimiento'] ?? ''); ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Teléfono</label>
      <input type="text" name="telefono" class="form-control" value="<?php echo htmlspecialchars($user['telefono']); ?>">
    </div>
    <button class="btn btn-primary">Actualizar</button>
    <a href="index.php" class="btn btn-secondary">Cancelar</a>
  </form>
</div>
</body>
</html>
