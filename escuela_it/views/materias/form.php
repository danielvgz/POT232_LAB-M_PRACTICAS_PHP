<div class="page-header"><h3><?php echo $row['id'] ? 'Editar' : 'Nueva'; ?> materia</h3></div>
<form method="post" action="index.php?controller=materias&action=save">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
    <div class="form-group"><label>Nombre</label><input class="form-control" name="nombre" required value="<?php echo htmlspecialchars($row['nombre']); ?>"></div>
    <div class="form-group"><label>Descripción</label><textarea class="form-control" name="descripcion"><?php echo htmlspecialchars($row['descripcion']); ?></textarea></div>
    <div class="row">
        <div class="col-sm-6 form-group">
            <label>Créditos</label>
            <input type="number" min="1" class="form-control" name="creditos" value="<?php echo htmlspecialchars($row['creditos']); ?>">
        </div>
        <div class="col-sm-6 form-group">
            <label>Docente</label>
            <select class="form-control" name="docente_id">
                <option value="">Sin asignar</option>
                <?php foreach ($docentes as $d): ?>
                    <option value="<?php echo (int) $d['id']; ?>" <?php echo ((string) $row['docente_id'] === (string) $d['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($d['nombre']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <button class="btn btn-primary">Guardar</button>
    <a class="btn btn-default" href="index.php?controller=materias&action=index">Cancelar</a>
</form>
