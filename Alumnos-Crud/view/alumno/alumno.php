<h1 class="page-header">Alumnos</h1>

<div class="well well-sm text-right">
    <a class="btn btn-primary" href="?c=Alumno&a=Crud">Nuevo alumno</a>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <th style="width:80px;"></th>
            <th style="width:180px;">Nombre</th>
            <th>Apellido</th>
            <th>Correo</th>
            <th style="width:120px;">Sexo</th>
            <th style="width:120px;">Nacimiento</th>
            <th style="width:60px;"></th>
            <th style="width:60px;"></th>
        </tr>
    </thead>
    
    <tr>
        <td colspan="8" class="text-center">
            <a href="?c=Alumno&a=excel">Exportar a Excel</a>
        </td>
    </tr>
    
    <?php foreach($this->model->Listar() as $r): ?>
        <tr>
            <td>
                <?php if($r->__GET('Foto') != ''): ?>
                    <img src="uploads/<?php echo $r->__GET('Foto'); ?>" style="width:100%;" />
                <?php endif; ?> 
            </td>
            <td><?php echo $r->__GET('Nombre'); ?></td>
            <td><?php echo $r->__GET('Apellido'); ?></td>
            <td><?php echo $r->__GET('Correo'); ?></td>
            <td><?php echo $r->__GET('Sexo') == 1 ? 'Hombre' : 'Mujer'; ?></td>
            <td><?php echo $r->__GET('FechaNacimiento'); ?></td>
            <td>
                <a href="?c=Alumno&a=Crud&id=<?php echo $r->id; ?>">Editar</a>
            </td>
            <td>
                <a onclick="javascript:return confirm('¿Seguro de eliminar este registro?');" href="?c=Alumno&a=Eliminar&id=<?php echo $r->id; ?>">Eliminar</a>
            </td>
        </tr>
    <?php endforeach; ?>
    
    <tfoot>
        <tr>
            <td colspan="8" class="text-center">
                <a href="?c=Alumno&a=excel">Exportar a Excel</a>
            </td>
        </tr>
    </tfoot>
</table> 
