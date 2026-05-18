<h3><?= $item ? 'Editar asignación' : 'Nueva asignación' ?></h3><hr>
<form method="post" action="<?= BASE_URL ?>/index.php?c=Asignaciones&a=<?= $item ? 'update' : 'store' ?>">
<?php if ($item): ?><input type="hidden" name="id" value="<?= (int)$item['id'] ?>"><?php endif; ?>
<div class="form-group"><label>Nombre</label><input class="form-control" name="nombre" value="<?= htmlspecialchars((string)($item['nombre'] ?? '')) ?>" required></div>
<div class="form-group"><label>Descripción</label><textarea class="form-control" name="descripcion"><?= htmlspecialchars((string)($item['descripcion'] ?? '')) ?></textarea></div>
<button class="btn btn-success">Guardar</button> <a class="btn btn-default" href="<?= BASE_URL ?>/index.php?c=Asignaciones&a=index">Volver</a>
</form>
