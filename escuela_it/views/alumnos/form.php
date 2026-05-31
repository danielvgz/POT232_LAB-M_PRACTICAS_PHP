<div class="page-header"><h3><?php echo $row['id'] ? 'Editar' : 'Nuevo'; ?> alumno</h3></div>
<form method="post" action="index.php?controller=alumnos&action=save">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
    <div class="row">
        <div class="col-sm-6 form-group"><label>Nombre</label><input class="form-control" name="nombre" required value="<?php echo htmlspecialchars($row['nombre']); ?>"></div>
        <div class="col-sm-6 form-group"><label>Apellido</label><input class="form-control" name="apellido" required value="<?php echo htmlspecialchars($row['apellido']); ?>"></div>
        <div class="col-sm-4 form-group"><label>Sexo</label><select class="form-control" name="sexo"><option value="1" <?php echo ((string)$row['sexo']==='1')?'selected':''; ?>>Masculino</option><option value="2" <?php echo ((string)$row['sexo']==='2')?'selected':''; ?>>Femenino</option></select></div>
        <div class="col-sm-4 form-group"><label>Fecha nacimiento</label><input type="date" class="form-control" name="fecha_nacimiento" value="<?php echo htmlspecialchars($row['fecha_nacimiento']); ?>"></div>
        <div class="col-sm-4 form-group"><label>Fecha registro</label><input type="date" class="form-control" name="fecha_registro" value="<?php echo htmlspecialchars($row['fecha_registro']); ?>"></div>
        <div class="col-sm-6 form-group"><label>Foto</label><input class="form-control" name="foto" value="<?php echo htmlspecialchars($row['foto']); ?>"></div>
        <div class="col-sm-6 form-group"><label>Correo</label><input type="email" class="form-control" name="correo" required value="<?php echo htmlspecialchars($row['correo']); ?>"></div>
    </div>
    <button class="btn btn-primary">Guardar</button>
    <a class="btn btn-default" href="index.php?controller=alumnos&action=index">Cancelar</a>
</form>
