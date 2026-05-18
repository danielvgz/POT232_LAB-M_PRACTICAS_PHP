<h3><?= $item ? 'Editar docente' : 'Nuevo docente' ?></h3><hr>
<form method="post" action="<?= BASE_URL ?>/index.php?c=Docentes&a=<?= $item ? 'update' : 'store' ?>">
<?php if ($item): ?><input type="hidden" name="id" value="<?= (int)$item['id'] ?>"><?php endif; ?>
<div class="row">
<div class="form-group col-sm-6"><label>Nombre</label><input class="form-control" name="nombre" value="<?= htmlspecialchars((string)($item['nombre'] ?? '')) ?>" required></div>
<div class="form-group col-sm-6"><label>Apellido</label><input class="form-control" name="apellido" value="<?= htmlspecialchars((string)($item['apellido'] ?? '')) ?>" required></div>
<div class="form-group col-sm-6"><label>Correo</label><input type="email" class="form-control" name="correo" value="<?= htmlspecialchars((string)($item['correo'] ?? '')) ?>" required></div>
<div class="form-group col-sm-6"><label>Especialidad</label><input class="form-control" name="especialidad" value="<?= htmlspecialchars((string)($item['especialidad'] ?? '')) ?>"></div>
</div>
<button class="btn btn-success">Guardar</button> <a class="btn btn-default" href="<?= BASE_URL ?>/index.php?c=Docentes&a=index">Volver</a>
</form>
