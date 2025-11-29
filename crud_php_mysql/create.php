<?php
// Formulario para crear usuario
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Crear Usuario</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
  <h1 class="h3 mb-3">Crear Usuario</h1>
  <form action="store.php" method="post">
    <div class="mb-3">
      <label class="form-label">Nombre</label>
      <input id="nombre" type="text" name="nombre" class="form-control" required maxlength="10" inputmode="text">
      <div class="invalid-feedback" id="error-nombre"></div>
    </div>
    <div class="mb-3">
      <label class="form-label">Cédula</label>
      <input id="cedula" type="text" name="cedula" class="form-control" required maxlength="13" inputmode="latin">
      <div class="invalid-feedback" id="error-cedula"></div>
    </div>
    <div class="mb-3">
      <label class="form-label">Fecha de nacimiento</label>
      <input id="fecha_nacimiento" type="date" name="fecha_nacimiento" class="form-control" required>
      <div class="invalid-feedback" id="error-fecha"></div>
    </div>
    <div class="mb-3">
      <label class="form-label">Edad</label>
      <input id="edad" type="number" name="edad" class="form-control" required min="0" max="99" inputmode="numeric">
      <div class="invalid-feedback" id="error-edad"></div>
    </div>
    
    <button class="btn btn-primary">Guardar</button>
    <a href="index.php" class="btn btn-secondary">Cancelar</a>
  </form>
</div>
<script>
  (function(){
    const form = document.querySelector('form');
    const nombre = document.getElementById('nombre');
    const cedula = document.getElementById('cedula');
    const fecha = document.getElementById('fecha_nacimiento');
    const edad = document.getElementById('edad');

    function setError(el, id, msg){
      const div = document.getElementById(id);
      if (msg){
        el.classList.add('is-invalid');
        div.textContent = msg;
      } else {
        el.classList.remove('is-invalid');
        div.textContent = '';
      }
    }

    function validateNombre(){
      const v = nombre.value.trim();
      if (!v) return setError(nombre, 'error-nombre', 'El nombre es obligatorio'), false;
      if (v.length > 10) return setError(nombre, 'error-nombre', 'El nombre no puede tener más de 10 caracteres'), false;
      // Permitir letras (incluye tildes) y espacios, sin dígitos
      if (!/^[A-Za-zÀ-ÿ\s]+$/.test(v)) return setError(nombre, 'error-nombre', 'Solo letras y espacios'), false;
      setError(nombre, 'error-nombre', '');
      return true;
    }

    function validateCedula(){
      const v = cedula.value.trim();
      if (!v) return setError(cedula, 'error-cedula', 'La cédula es obligatoria'), false;
      if (v.length > 10) return setError(cedula, 'error-cedula', 'La cédula no puede tener más de 10 caracteres'), false;
      // Debe empezar por UNA letra, opcionalmente un '-' y luego sólo dígitos
      if (!/^[A-Za-z]-?\d+$/.test(v)) return setError(cedula, 'error-cedula', 'Formato inválido: una letra, opcional "-", luego números'), false;
      setError(cedula, 'error-cedula', '');
      return true;
    }

    function validateFecha(){
      const v = fecha.value;
      if (!v) return setError(fecha, 'error-fecha', 'La fecha de nacimiento es obligatoria'), false;
      setError(fecha, 'error-fecha', '');
      return true;
    }

    function validateEdad(){
      let v = edad.value;
      // limitar a dígitos y máximo 2 caracteres
      v = v.replace(/[^0-9]/g, '');
      if (v.length > 2) v = v.slice(0,2);
      edad.value = v;
      if (v === '') return setError(edad, 'error-edad', 'La edad es obligatoria'), false;
      const n = parseInt(v, 10);
      if (!Number.isInteger(n) || n < 0 || n > 99) return setError(edad, 'error-edad', 'La edad debe ser un número entre 0 y 99'), false;
      setError(edad, 'error-edad', '');
      return true;
    }

    nombre.addEventListener('input', validateNombre);
    cedula.addEventListener('input', validateCedula);
    fecha.addEventListener('change', validateFecha);
    edad.addEventListener('input', validateEdad);

    form.addEventListener('submit', function(e){
      const ok = validateNombre() & validateCedula() & validateFecha() & validateEdad();
      if (!ok) e.preventDefault();
    });
  })();
</script>
</body>
</html>
