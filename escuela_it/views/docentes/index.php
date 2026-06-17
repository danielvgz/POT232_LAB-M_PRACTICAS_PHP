<div class="page-header">
    <h3>Docentes</h3>
</div>
<a class="btn btn-success" href="index.php?controller=docentes&action=form">Nuevo docente</a>
<br><br>
<table class="table table-bordered table-striped">
    <thead>
    <tr>
        <th>ID</th><th>Nombre</th><th>Apellido</th><th>Correo</th><th>Acciones</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($rows as $r): ?>
        <tr>
            <td><?php echo (int) $r['id']; ?></td>
            <td><?php echo htmlspecialchars($r['nombre']); ?></td>
            <td><?php echo htmlspecialchars($r['apellido']); ?></td>
            <td><?php echo htmlspecialchars($r['correo']); ?></td>
            <td>
                <a class="btn btn-primary btn-xs" href="index.php?controller=docentes&action=form&id=<?php echo (int) $r['id']; ?>">Editar</a>
                <a class="btn btn-danger btn-xs" href="index.php?controller=docentes&action=delete&id=<?php echo (int) $r['id']; ?>" onclick="return confirm('¿Eliminar registro?');">Eliminar</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
