<div class="page-header"><h3>Materias</h3></div>
<a class="btn btn-success" href="index.php?controller=materias&action=form">Nueva materia</a>
<br><br>
<table class="table table-bordered table-striped">
    <thead><tr><th>ID</th><th>Nombre</th><th>Descripción</th><th>Acciones</th></tr></thead>
    <tbody>
    <?php foreach ($rows as $r): ?>
        <tr>
            <td><?php echo (int) $r['id']; ?></td>
            <td><?php echo htmlspecialchars($r['nombre']); ?></td>
            <td><?php echo htmlspecialchars($r['descripcion']); ?></td>
            <td>
                <a class="btn btn-primary btn-xs" href="index.php?controller=materias&action=form&id=<?php echo (int) $r['id']; ?>">Editar</a>
                <a class="btn btn-danger btn-xs" href="index.php?controller=materias&action=delete&id=<?php echo (int) $r['id']; ?>" onclick="return confirm('¿Eliminar registro?');">Eliminar</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
