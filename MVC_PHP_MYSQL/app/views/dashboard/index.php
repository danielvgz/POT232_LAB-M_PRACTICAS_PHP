<h3>Panel principal</h3>
<p>Bienvenido, <strong><?= htmlspecialchars((string)$user['username']) ?></strong>.</p>

<?php if ($user['rol'] === 'admin'): ?>
    <div class="alert alert-info">Como administrador tienes acceso completo a todos los CRUD.</div>
<?php endif; ?>

<?php if ($user['rol'] === 'docente'): ?>
    <h4>Mis asignaciones</h4>
    <ul class="list-group">
        <?php foreach ($items as $row): ?>
            <li class="list-group-item"><?= htmlspecialchars((string)$row['asignacion_nombre']) ?></li>
        <?php endforeach; ?>
        <?php if (!$items): ?><li class="list-group-item">No tienes asignaciones.</li><?php endif; ?>
    </ul>

    <h4>Alumnos inscritos</h4>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead><tr><th>Asignación</th><th>Alumno</th><th>Correo</th><th>Fecha</th></tr></thead>
            <tbody>
            <?php foreach ($enrolled as $row): ?>
                <tr>
                    <td><?= htmlspecialchars((string)$row['asignacion']) ?></td>
                    <td><?= htmlspecialchars((string)$row['alumno_nombre'] . ' ' . $row['alumno_apellido']) ?></td>
                    <td><?= htmlspecialchars((string)$row['correo']) ?></td>
                    <td><?= htmlspecialchars((string)$row['fecha_inscripcion']) ?></td>
                </tr>
            <?php endforeach; ?>
            <?php if (!$enrolled): ?><tr><td colspan="4">Sin inscripciones.</td></tr><?php endif; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php if ($user['rol'] === 'alumno'): ?>
    <h4>Asignaciones disponibles</h4>
    <ul class="list-group">
        <?php foreach ($items as $row): ?>
            <li class="list-group-item"><?= htmlspecialchars((string)$row['asignacion_nombre'] . ' - ' . $row['docente_nombre'] . ' ' . $row['docente_apellido']) ?></li>
        <?php endforeach; ?>
        <?php if (!$items): ?><li class="list-group-item">No hay asignaciones disponibles.</li><?php endif; ?>
    </ul>

    <h4>Mis inscripciones</h4>
    <ul class="list-group">
        <?php foreach ($enrolled as $row): ?>
            <li class="list-group-item"><?= htmlspecialchars((string)$row['asignacion_nombre'] . ' - ' . $row['docente_nombre'] . ' ' . $row['docente_apellido']) ?> (<?= htmlspecialchars((string)$row['fecha_inscripcion']) ?>)</li>
        <?php endforeach; ?>
        <?php if (!$enrolled): ?><li class="list-group-item">Aún no tienes inscripciones.</li><?php endif; ?>
    </ul>
<?php endif; ?>
