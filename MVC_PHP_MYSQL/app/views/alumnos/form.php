<h3><?= $item ? 'Editar alumno' : 'Nuevo alumno' ?></h3><hr>
<form method="post" enctype="multipart/form-data" action="<?= BASE_URL ?>/index.php?c=Alumnos&a=<?= $item ? 'update' : 'store' ?>">
    <?php if ($item): ?><input type="hidden" name="id" value="<?= (int)$item['id'] ?>"><?php endif; ?>
    <div class="row">
        <div class="form-group col-sm-6"><label>Nombre</label><input class="form-control" name="nombre" value="<?= htmlspecialchars((string)($item['nombre'] ?? '')) ?>" required></div>
        <div class="form-group col-sm-6"><label>Apellido</label><input class="form-control" name="apellido" value="<?= htmlspecialchars((string)($item['apellido'] ?? '')) ?>" required></div>
        <div class="form-group col-sm-4"><label>Sexo</label><select class="form-control" name="sexo"><option value="1" <?= ((int)($item['sexo'] ?? 1) === 1) ? 'selected' : '' ?>>Masculino</option><option value="2" <?= ((int)($item['sexo'] ?? 0) === 2) ? 'selected' : '' ?>>Femenino</option></select></div>
        <div class="form-group col-sm-4"><label>Nacimiento</label><input type="date" class="form-control" name="fecha_nacimiento" value="<?= htmlspecialchars((string)($item['fecha_nacimiento'] ?? '')) ?>"></div>
        <div class="form-group col-sm-4"><label>Registro</label><input type="date" class="form-control" name="fecha_registro" value="<?= htmlspecialchars((string)($item['fecha_registro'] ?? date('Y-m-d'))) ?>"></div>
        <div class="form-group col-sm-6"><label>Correo</label><input type="email" class="form-control" name="correo" value="<?= htmlspecialchars((string)($item['correo'] ?? '')) ?>" required></div>
        <div class="form-group col-sm-6"><label>Foto (jpeg/png/webp, máx 2MB)</label><input type="file" class="form-control" name="foto" accept=".jpg,.jpeg,.png,.webp"></div>
    </div>
    <button class="btn btn-success" type="submit">Guardar</button>
    <a class="btn btn-default" href="<?= BASE_URL ?>/index.php?c=Alumnos&a=index">Volver</a>
</form>
