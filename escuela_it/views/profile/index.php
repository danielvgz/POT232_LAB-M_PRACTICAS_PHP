<div class="page-header"><h3>Mi perfil</h3></div>
<form method="post" action="index.php?controller=profile&action=save">
    <div class="row">
        <div class="col-sm-6 form-group"><label>Nombre</label><input class="form-control" name="nombre" value="<?php echo htmlspecialchars(isset($profile['nombre']) ? $profile['nombre'] : ''); ?>"></div>
        <div class="col-sm-6 form-group"><label>Apellido</label><input class="form-control" name="apellido" value="<?php echo htmlspecialchars(isset($profile['apellido']) ? $profile['apellido'] : ''); ?>"></div>
        <div class="col-sm-4 form-group"><label>Sexo</label><select class="form-control" name="sexo"><option value="1" <?php echo ((string)($profile['sexo'] ?? '1') === '1') ? 'selected' : ''; ?>>Masculino</option><option value="2" <?php echo ((string)($profile['sexo'] ?? '1') === '2') ? 'selected' : ''; ?>>Femenino</option></select></div>
        <div class="col-sm-4 form-group"><label>Fecha nacimiento</label><input type="date" class="form-control" name="fecha_nacimiento" value="<?php echo htmlspecialchars($profile['fecha_nacimiento'] ?? ''); ?>"></div>
        <div class="col-sm-4 form-group"><label>Foto</label><input class="form-control" name="foto" value="<?php echo htmlspecialchars($profile['foto'] ?? ''); ?>"></div>
        <div class="col-sm-6 form-group"><label>Correo</label><input type="email" class="form-control" name="correo" value="<?php echo htmlspecialchars($profile['correo'] ?? ''); ?>"></div>
        <div class="col-sm-6 form-group"><label>Nueva clave</label><input type="password" class="form-control" name="password" value=""></div>
    </div>
    <button class="btn btn-primary">Guardar cambios</button>
</form>
