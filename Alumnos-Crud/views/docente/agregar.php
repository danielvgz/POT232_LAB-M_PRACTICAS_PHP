<h1 class="page-header">Nuevo Docente</h1>

<ol class="breadcrumb">
  <li><a href="?c=Docente">Docentes</a></li>
  <li class="active">Nuevo Registro</li>
</ol>

<form id="frm-docente-agregar" action="?c=Docente&a=Guardar" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label>Nombre</label>
        <input type="text" name="Nombre" class="form-control" placeholder="Ingrese su nombre" data-validacion-tipo="requerido|min:3" />
    </div>

    <div class="form-group">
        <label>Apellido</label>
        <input type="text" name="Apellido" class="form-control" placeholder="Ingrese su apellido" data-validacion-tipo="requerido|min:3" />
    </div>

    <div class="form-group">
        <label>Correo</label>
        <input type="text" name="Correo" class="form-control" placeholder="Ingrese su correo electrónico" data-validacion-tipo="requerido|email" />
    </div>

    <div class="form-group">
        <label>Sexo</label>
        <select name="Sexo" class="form-control">
            <option value="1">Masculino</option>
            <option value="2">Femenino</option>
        </select>
    </div>

    <div class="form-group">
        <label>Fecha de nacimiento</label>
        <input readonly type="text" name="FechaNacimiento" class="form-control datepicker" placeholder="Ingrese su fecha de nacimiento" data-validacion-tipo="requerido" />
    </div>

    <div class="form-group">
        <label>Foto</label>
        <input type="hidden" name="Foto" value="" />
        <input type="file" name="Foto" placeholder="Ingrese una imagen" />
    </div>

    <hr />

    <div class="text-right">
        <button class="btn btn-success">Guardar</button>
    </div>
</form>

<script>
    $(document).ready(function(){
        $("#frm-docente-agregar").submit(function(){
            return $(this).validate();
        });
    })
</script>
