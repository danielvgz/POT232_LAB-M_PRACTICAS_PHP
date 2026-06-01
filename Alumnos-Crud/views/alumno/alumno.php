<h1 class="page-header">Alumnos</h1>

<?php if (!empty($_GET['msg']) && $_GET['msg'] === 'sin_permiso'): ?>
    <div class="alert alert-danger">No tiene permisos para esta acción.</div>
<?php endif; ?>

<div class="well well-sm text-right">
    <a class="btn btn-primary" href="?c=Alumno&a=Crud">Nuevo alumno</a>
    <a class="btn btn-success" href="?c=Alumno&a=Excel">Exportar a Excel</a>
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
            <th style="width:60px;">Editar</th>
            <th style="width:80px;">Eliminar</th>
        </tr>
    </thead>
    <tbody>
    <?php if (empty($alumnos)): ?>
        <tr>
            <td colspan="8">No hay alumnos registrados.</td>
        </tr>
    <?php else: ?>
        <?php foreach ($alumnos as $r): ?>
            <tr>
                <td>
                    <?php if($r->__GET('Foto') != ''): ?>
                        <img src="uploads/<?php echo htmlspecialchars($r->__GET('Foto')); ?>" style="width:100%;" />
                    <?php endif; ?> 
                </td>
                <td><?php echo htmlspecialchars($r->__GET('Nombre')); ?></td>
                <td><?php echo htmlspecialchars($r->__GET('Apellido')); ?></td>
                <td><?php echo htmlspecialchars($r->__GET('Correo')); ?></td>
                <td><?php echo $r->__GET('Sexo') == 1 ? 'Hombre' : 'Mujer'; ?></td>
                <td><?php echo htmlspecialchars($r->__GET('FechaNacimiento')); ?></td>
                <td>
                    <a href="?c=Alumno&a=Crud&id=<?php echo (int)$r->__GET('id'); ?>">Editar</a>
                </td>
                <td>
                    <a onclick="javascript:return confirm('¿Seguro de eliminar este registro?');" href="?c=Alumno&a=Eliminar&id=<?php echo (int)$r->__GET('id'); ?>">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>

<?php if ($totalPaginas > 1): ?>
    <nav>
        <ul class="pagination">
            <?php for ($pagina = 1; $pagina <= $totalPaginas; $pagina++): ?>
                <li class="<?php echo $pagina === $paginaActual ? 'active' : ''; ?>">
                    <a href="?c=Alumno&page=<?php echo $pagina; ?>"><?php echo $pagina; ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
<?php endif; ?>

<?php if (!empty($esAdmin)): ?>
    <h3>Asignar rol de profesor</h3>
    <p class="text-muted">Solo el administrador puede convertir usuarios con rol alumno a profesor.</p>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Correo</th>
                <th>Rol actual</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($usuariosAlumno as $usuario): ?>
                <tr>
                    <td><?php echo htmlspecialchars($usuario->username); ?></td>
                    <td><?php echo htmlspecialchars($usuario->correo); ?></td>
                    <td><?php echo htmlspecialchars($usuario->rol); ?></td>
                    <td>
                        <a class="btn btn-xs btn-warning"
                           href="index.php?action=asignar_profesor&id=<?php echo (int)$usuario->id; ?>"
                           onclick="return confirm('¿Asignar rol profesor a este usuario?');">
                            Asignar profesor
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
