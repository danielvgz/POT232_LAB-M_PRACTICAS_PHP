<h3>Mis inscripciones</h3><hr>
<table class="table table-bordered table-striped"><thead><tr><th>ID</th><th>Asignación</th><th>Docente</th><th>Fecha</th></tr></thead><tbody>
<?php foreach ($rows as $r): ?><tr><td><?= (int)$r['id'] ?></td><td><?= htmlspecialchars((string)$r['asignacion_nombre']) ?></td><td><?= htmlspecialchars((string)$r['docente_nombre'].' '.$r['docente_apellido']) ?></td><td><?= htmlspecialchars((string)$r['fecha_inscripcion']) ?></td></tr><?php endforeach; ?>
<?php if (!$rows): ?><tr><td colspan="4">Aún no tienes inscripciones.</td></tr><?php endif; ?></tbody></table>
