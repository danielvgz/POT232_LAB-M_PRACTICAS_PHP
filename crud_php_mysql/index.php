<?php
require_once 'db_connect.php';

// Mensaje opcional
$msg = '';
if (isset($_GET['msg'])) {
    $msg = htmlspecialchars($_GET['msg']);
}

$st = $pdo->query('SELECT * FROM users ORDER BY id DESC');
$users = $st->fetchAll();
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Usuarios - CRUD</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3">Usuarios</h1>
    <a href="create.php" class="btn btn-primary">Crear nuevo</a>
  </div>

  <?php if ($msg): ?>
    <div class="alert alert-info"><?php echo $msg; ?></div>
  <?php endif; ?>

  <table class="table table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>Nombre</th>
        <th>Cédula</th>
        <th>Fecha Nac.</th>
        <th>Edad</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
    <?php if ($users): foreach ($users as $u): ?>
      <tr>
        <td><?php echo $u['id']; ?></td>
        <td><?php echo htmlspecialchars($u['nombre']); ?></td>
        <td><?php echo htmlspecialchars($u['cedula'] ?? ''); ?></td>
        <td><?php echo htmlspecialchars($u['fecha_nacimiento'] ?? ''); ?></td>
        <td><?php echo htmlspecialchars($u['edad'] ?? ''); ?></td>
        <td>
          <a href="view.php?id=<?php echo $u['id']; ?>" class="btn btn-sm btn-outline-secondary">Ver</a>
          <a href="edit.php?id=<?php echo $u['id']; ?>" class="btn btn-sm btn-warning">Editar</a>
          <a href="delete.php?id=<?php echo $u['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Eliminar este usuario?');">Eliminar</a>
        </td>
      </tr>
    <?php endforeach; else: ?>
      <tr><td colspan="6">No hay usuarios.</td></tr>
    <?php endif; ?>
    </tbody>
  </table>
</div>
</body>
</html>
