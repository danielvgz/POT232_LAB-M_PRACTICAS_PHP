<div class="page-header"><h3><?php echo $row['id'] ? 'Editar' : 'Nueva'; ?> materia</h3></div>
<form method="post" action="index.php?controller=materias&action=save">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
    <div class="form-group"><label>Nombre</label><input class="form-control" name="nombre" required value="<?php echo htmlspecialchars($row['nombre']); ?>"></div>
    <div class="form-group"><label>Descripción</label><textarea class="form-control" name="descripcion"><?php echo htmlspecialchars($row['descripcion']); ?></textarea></div>
    <button class="btn btn-primary">Guardar</button>
    <a class="btn btn-default" href="index.php?controller=materias&action=index">Cancelar</a>
</form>
