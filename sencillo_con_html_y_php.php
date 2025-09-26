<?php
// Función para validar nombre (solo letras y espacios)
function validarNombre($nombre) {
    return preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $nombre);
}

// Función para validar correo (debe tener @ y terminar en .com)
function validarCorreo($correo) {
    return strpos($correo, '@') !== false && substr($correo, -4) === '.com';
}

// Función para calcular edad
function calcularEdad($fechaNacimiento) {
    $fechaNac = new DateTime($fechaNacimiento);
    $fechaActual = new DateTime();
    $diferencia = $fechaActual->diff($fechaNac);
    return $diferencia->y;
}

// Variable para almacenar mensajes
$mensaje = "";
$error = "";

// Procesar formulario si se envió
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    $fechaNacimiento = $_POST['fechaNacimiento'];
    
    // Validar campos vacíos
    if (empty($nombre) || empty($correo) || empty($fechaNacimiento)) {
        $error = "Por favor, completa todos los campos.";
    }
    // Validar nombre
    elseif (!validarNombre($nombre)) {
        $error = "El nombre solo debe contener letras y espacios.";
    }
    // Validar correo
    elseif (!validarCorreo($correo)) {
        $error = "El correo debe contener un @ y terminar en .com";
    }
    // Si todo está correcto, calcular edad
    else {
        $edad = calcularEdad($fechaNacimiento);
        $mensaje = "¡Hola " . htmlspecialchars($nombre) . "!\n\nTu edad es: " . $edad . " años\n\nCorreo registrado: " . htmlspecialchars($correo);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculador de Edad - PHP</title>
</head>
<body>
    <h1>Calculador de Edad (PHP)</h1>
    
    <?php if (!empty($error)): ?>
        <div style="color: red; background: #ffebee; padding: 10px; border: 1px solid red; margin-bottom: 15px;">
            <strong>Error:</strong> <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($mensaje)): ?>
        <div style="color: green; background: #e8f5e8; padding: 15px; border: 1px solid green; margin-bottom: 15px;">
            <h3>Resultado:</h3>
            <pre><?php echo htmlspecialchars($mensaje); ?></pre>
        </div>
    <?php endif; ?>
    
    <form method="POST" action="">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : ''; ?>" required>
        <br><br>
        
        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" value="<?php echo isset($_POST['correo']) ? htmlspecialchars($_POST['correo']) : ''; ?>" required>
        <br><br>
        
        <label for="fechaNacimiento">Fecha de Nacimiento:</label>
        <input type="date" id="fechaNacimiento" name="fechaNacimiento" value="<?php echo isset($_POST['fechaNacimiento']) ? htmlspecialchars($_POST['fechaNacimiento']) : ''; ?>" required>
        <br><br>
        
        <button type="submit">Validar con PHP</button>
    </form>

    <hr>
    <h2>Explicación del código PHP:</h2>
    <ul>
        <li><strong>$_SERVER['REQUEST_METHOD']:</strong> Detecta si el formulario fue enviado</li>
        <li><strong>$_POST['campo']:</strong> Obtiene los datos del formulario</li>
        <li><strong>htmlspecialchars():</strong> Previene ataques XSS</li>
        <li><strong>DateTime:</strong> Clase de PHP para manejar fechas</li>
        <li><strong>preg_match():</strong> Validación con expresiones regulares</li>
    </ul>

    <h3>Diferencias clave con JavaScript:</h3>
    <ul>
        <li>✅ <strong>PHP se ejecuta en el servidor</strong> antes de enviar la página</li>
        <li>✅ <strong>JavaScript se ejecuta en el navegador</strong> después de cargar la página</li>
        <li>✅ <strong>PHP puede acceder a bases de datos</strong> directamente</li>
        <li>✅ <strong>PHP es más seguro</strong> para validaciones críticas</li>
        <li>✅ <strong>JavaScript es más interactivo</strong> sin recargar página</li>
    </ul>
</body>
</html>