<h1 class="page-header">Eliminar Docente</h1>

<ol class="breadcrumb">
  <li><a href="?c=Docente">Docentes</a></li>
  <li class="active">Eliminar</li>
</ol>

<div class="alert alert-danger">
    ¿Seguro de eliminar el registro de <strong><?php echo $doc->__GET('Nombre') . ' ' . $doc->__GET('Apellido'); ?></strong>?
</div>

<div class="text-right">
    <a class="btn btn-default" href="?c=Docente">Cancelar</a>
    <a class="btn btn-danger" href="?c=Docente&a=ConfirmarEliminar&id=<?php echo $doc->__GET('id'); ?>">Eliminar</a>
</div>
