<div class="page-header"><h3><?php echo isset($title) ? htmlspecialchars($title) : 'Matriculas'; ?></h3></div>
<?php if (!empty($canManage)): ?>
    <a class="btn btn-success" href="index.php?controller=matriculas&action=form">Nueva asignacion</a>
    <br><br>
<?php endif; ?>
<table class="table table-bordered table-striped">
    <thead><tr><th>ID</th><th>Alumno</th><th>Docente</th><th>Materia</th><th>Fecha</th><?php if (!empty($canManage)): ?><th>Acciones</th><?php endif; ?></tr></thead>
    <tbody>
    <?php if (empty($rows)): ?>
        <tr><td colspan="<?php echo !empty($canManage) ? 6 : 5; ?>">No hay registros disponibles.</td></tr>
    <?php endif; ?>
    <?php foreach ($rows as $r): ?>
        <tr>
            <td><?php echo (int) $r['id']; ?></td>
            <td><?php echo htmlspecialchars($r['alumno_nombre'] . ' ' . $r['alumno_apellido']); ?></td>
            <td><?php echo htmlspecialchars($r['docente_nombre'] . ' ' . $r['docente_apellido']); ?></td>
            <td><?php echo htmlspecialchars($r['materia_nombre']); ?></td>
            <td><?php echo htmlspecialchars($r['fecha_matricula']); ?></td>
            <?php if (!empty($canManage)): ?>
                <td>
                    <a class="btn btn-primary btn-xs" href="index.php?controller=matriculas&action=form&id=<?php echo (int) $r['id']; ?>">Editar</a>
                    <a class="btn btn-danger btn-xs" href="index.php?controller=matriculas&action=delete&id=<?php echo (int) $r['id']; ?>" onclick="return confirm('¿Eliminar registro?');">Eliminar</a>
                </td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
