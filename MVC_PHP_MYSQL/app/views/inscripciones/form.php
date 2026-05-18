<h3><?= $item ? 'Editar inscripción' : 'Nueva inscripción' ?></h3><hr>
<form method="post" action="<?= BASE_URL ?>/index.php?c=Inscripciones&a=<?= $item ? 'update' : 'store' ?>">
<?php if ($item): ?><input type="hidden" name="id" value="<?= (int)$item['id'] ?>"><?php endif; ?>
<div class="form-group"><label>Alumno</label><select class="form-control" name="id_alumno" required><?php foreach ($alumnos as $al): ?><option value="<?= (int)$al['id'] ?>" <?= ((string)($item['id_alumno'] ?? '') === (string)$al['id']) ? 'selected' : '' ?>><?= htmlspecialchars((string)$al['nombre'].' '.$al['apellido']) ?></option><?php endforeach; ?></select></div>
<div class="form-group"><label>Asignación-Docente</label><select class="form-control" name="id_asignacion_docente" required><?php foreach ($asignacionesDocente as $ad): ?><option value="<?= (int)$ad['id'] ?>" <?= ((string)($item['id_asignacion_docente'] ?? '') === (string)$ad['id']) ? 'selected' : '' ?>><?= htmlspecialchars((string)$ad['asignacion_nombre'].' - '.$ad['docente_nombre'].' '.$ad['docente_apellido']) ?></option><?php endforeach; ?></select></div>
<div class="form-group"><label>Fecha inscripción</label><input type="date" class="form-control" name="fecha_inscripcion" value="<?= htmlspecialchars((string)($item['fecha_inscripcion'] ?? date('Y-m-d'))) ?>" required></div>
<button class="btn btn-success">Guardar</button> <a class="btn btn-default" href="<?= BASE_URL ?>/index.php?c=Inscripciones&a=index">Volver</a>
</form>
