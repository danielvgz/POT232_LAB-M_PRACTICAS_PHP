<h3>Asignaciones disponibles para inscribirte</h3><hr>
<table class="table table-bordered table-striped"><thead><tr><th>Asignación</th><th>Docente</th><th></th></tr></thead><tbody>
<?php foreach ($rows as $r): ?><tr><td><?= htmlspecialchars((string)$r['asignacion_nombre']) ?></td><td><?= htmlspecialchars((string)$r['docente_nombre'].' '.$r['docente_apellido']) ?></td><td><a class="btn btn-success btn-xs" href="<?= BASE_URL ?>/index.php?c=Inscripciones&a=selfEnroll&id_asignacion_docente=<?= (int)$r['id'] ?>" onclick="return confirm('¿Confirmar inscripción?');">Inscribirme</a></td></tr><?php endforeach; ?>
<?php if (!$rows): ?><tr><td colspan="3">No hay asignaciones disponibles.</td></tr><?php endif; ?></tbody></table>
