<h3>Alumnos inscritos en mis asignaciones</h3><hr>
<table class="table table-bordered table-striped"><thead><tr><th>Asignación</th><th>Alumno</th><th>Correo</th><th>Fecha</th></tr></thead><tbody>
<?php foreach ($rows as $r): ?><tr><td><?= htmlspecialchars((string)$r['asignacion']) ?></td><td><?= htmlspecialchars((string)$r['alumno_nombre'].' '.$r['alumno_apellido']) ?></td><td><?= htmlspecialchars((string)$r['correo']) ?></td><td><?= htmlspecialchars((string)$r['fecha_inscripcion']) ?></td></tr><?php endforeach; ?>
<?php if (!$rows): ?><tr><td colspan="4">Sin registros.</td></tr><?php endif; ?></tbody></table>
