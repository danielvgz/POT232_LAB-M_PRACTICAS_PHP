<div class="page-header"><h3>Matriculas</h3></div>
<a class="btn btn-success" href="index.php?controller=matriculas&action=form">Nueva matricula</a>
<br><br>
<table class="table table-bordered table-striped">
    <thead><tr><th>ID</th><th>Alumno</th><th>Docente</th><th>Materia</th><th>Fecha</th><th>Acciones</th></tr></thead>
    <tbody>
    <?php foreach ($rows as $r): ?>
        <tr>
            <td><?php echo (int) $r['id']; ?></td>
            <td><?php echo htmlspecialchars($r['alumno_nombre'] . ' ' . $r['alumno_apellido']); ?></td>
            <td><?php echo htmlspecialchars($r['docente_nombre'] . ' ' . $r['docente_apellido']); ?></td>
            <td><?php echo htmlspecialchars($r['materia_nombre']); ?></td>
            <td><?php echo htmlspecialchars($r['fecha_matricula']); ?></td>
            <td>
                <a class="btn btn-primary btn-xs" href="index.php?controller=matriculas&action=form&id=<?php echo (int) $r['id']; ?>">Editar</a>
                <a class="btn btn-danger btn-xs" href="index.php?controller=matriculas&action=delete&id=<?php echo (int) $r['id']; ?>" onclick="return confirm('¿Eliminar registro?');">Eliminar</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
