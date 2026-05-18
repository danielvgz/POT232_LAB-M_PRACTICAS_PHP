<h3><?= $item ? 'Editar asignación-docente' : 'Nueva asignación-docente' ?></h3><hr>
<form method="post" action="<?= BASE_URL ?>/index.php?c=AsignacionesDocente&a=<?= $item ? 'update' : 'store' ?>">
<?php if ($item): ?><input type="hidden" name="id" value="<?= (int)$item['id'] ?>"><?php endif; ?>
<div class="form-group"><label>Asignación</label><select class="form-control" name="id_asignacion" required><?php foreach ($asignaciones as $a): ?><option value="<?= (int)$a['id'] ?>" <?= ((string)($item['id_asignacion'] ?? '') === (string)$a['id']) ? 'selected' : '' ?>><?= htmlspecialchars((string)$a['nombre']) ?></option><?php endforeach; ?></select></div>
<div class="form-group"><label>Docente</label><select class="form-control" name="id_docente" required><?php foreach ($docentes as $d): ?><option value="<?= (int)$d['id'] ?>" <?= ((string)($item['id_docente'] ?? '') === (string)$d['id']) ? 'selected' : '' ?>><?= htmlspecialchars((string)$d['nombre'].' '.$d['apellido']) ?></option><?php endforeach; ?></select></div>
<button class="btn btn-success">Guardar</button> <a class="btn btn-default" href="<?= BASE_URL ?>/index.php?c=AsignacionesDocente&a=index">Volver</a>
</form>
