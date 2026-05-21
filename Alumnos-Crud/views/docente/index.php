<h1 class="page-header">Docentes</h1>

<div class="well well-sm text-right">
    <a class="btn btn-primary" href="?c=Docente&a=Agregar">Nuevo docente</a>
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
            <th style="width:80px;"></th>
        </tr>
    </thead>

    <?php foreach($docentes as $r): ?>
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
                <a href="?c=Docente&a=Editar&id=<?php echo $r->id; ?>">Editar</a>
            </td>
            <td>
                <a href="?c=Docente&a=Eliminar&id=<?php echo $r->id; ?>">Eliminar</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
