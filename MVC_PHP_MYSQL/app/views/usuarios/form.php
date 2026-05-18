<h3><?= $item ? 'Editar usuario' : 'Nuevo usuario' ?></h3><hr>
<form method="post" action="<?= BASE_URL ?>/index.php?c=Usuarios&a=<?= $item ? 'update' : 'store' ?>">
<?php if ($item): ?><input type="hidden" name="id" value="<?= (int)$item['id'] ?>"><?php endif; ?>
<div class="row">
<div class="form-group col-sm-4"><label>Username</label><input class="form-control" name="username" value="<?= htmlspecialchars((string)($item['username'] ?? '')) ?>" required></div>
<div class="form-group col-sm-4"><label>Correo</label><input type="email" class="form-control" name="correo" value="<?= htmlspecialchars((string)($item['correo'] ?? '')) ?>" required></div>
<div class="form-group col-sm-4"><label>Rol</label>
<select name="rol" class="form-control" required>
<?php foreach (['admin','docente','alumno'] as $rol): ?>
<option value="<?= $rol ?>" <?= (($item['rol'] ?? 'alumno') === $rol) ? 'selected' : '' ?>><?= ucfirst($rol) ?></option>
<?php endforeach; ?>
</select>
</div>
<div class="form-group col-sm-4"><label>Contraseña <?= $item ? '(opcional)' : '' ?></label><input type="password" class="form-control" name="password" <?= $item ? '' : 'required' ?>></div>
<div class="form-group col-sm-4"><label>Alumno asociado</label><select class="form-control" name="alumno_id"><option value="">-- ninguno --</option><?php foreach ($alumnos as $al): ?><option value="<?= (int)$al['id'] ?>" <?= ((string)($item['alumno_id'] ?? '') === (string)$al['id']) ? 'selected' : '' ?>><?= htmlspecialchars((string)$al['nombre'].' '.$al['apellido']) ?></option><?php endforeach; ?></select></div>
<div class="form-group col-sm-4"><label>Docente asociado</label><select class="form-control" name="docente_id"><option value="">-- ninguno --</option><?php foreach ($docentes as $dc): ?><option value="<?= (int)$dc['id'] ?>" <?= ((string)($item['docente_id'] ?? '') === (string)$dc['id']) ? 'selected' : '' ?>><?= htmlspecialchars((string)$dc['nombre'].' '.$dc['apellido']) ?></option><?php endforeach; ?></select></div>
</div>
<button class="btn btn-success">Guardar</button> <a class="btn btn-default" href="<?= BASE_URL ?>/index.php?c=Usuarios&a=index">Volver</a>
</form>
