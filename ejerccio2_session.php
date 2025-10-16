<?php
session_start();

// Valores por defecto
$defaults = array(
    'nombre' => 'Juan Carlos Pérez',
    'fecha_nacimiento' => '2002-03-15',
    'carrera' => 'Ingeniería en Sistemas',
    'universidad' => 'Universidad Tecnológica',
    'ciudad' => 'Ciudad de México',
    'email' => 'juan.carlos@email.com',
    'telefono' => '+52 55 1234-5678',
    'opcion' => '' // género
);

// Inicializar sesión si no existe
if (!isset($_SESSION['perfil'])) {
    $_SESSION['perfil'] = $defaults;
}

// Funciones auxiliares
function calcular_edad_exacta($fecha_nacimiento) {
    $hoy = new DateTime();
    $nacimiento = new DateTime($fecha_nacimiento);
    $diferencia = $hoy->diff($nacimiento);
    return array(
        'años' => $diferencia->y,
        'meses' => $diferencia->m,
        'dias' => $diferencia->d,
        'total_dias' => $hoy->diff($nacimiento)->days
    );
}

function dias_hasta_cumpleanos($fecha_nacimiento) {
    $hoy = new DateTime();
    $cumple_este_año = new DateTime(date('Y') . substr($fecha_nacimiento, 4));
    if ($cumple_este_año < $hoy) {
        $cumple_este_año = new DateTime((date('Y') + 1) . substr($fecha_nacimiento, 4));
    }
    $diferencia = $hoy->diff($cumple_este_año);
    return $diferencia->days;
}

// Procesar acciones vía GET y redirigir para limpiar la URL (RGG: Redirect after GET)
if (isset($_GET['accion'])) {
    $accion = $_GET['accion'];

    if ($accion === 'actualizar') {
        $perfil = $_SESSION['perfil'];
        $perfil['nombre'] = isset($_GET['nombre']) && $_GET['nombre'] !== '' ? $_GET['nombre'] : $perfil['nombre'];
        $perfil['fecha_nacimiento'] = isset($_GET['fecha_nacimiento']) && $_GET['fecha_nacimiento'] !== '' ? $_GET['fecha_nacimiento'] : $perfil['fecha_nacimiento'];
        $perfil['carrera'] = isset($_GET['carrera']) && $_GET['carrera'] !== '' ? $_GET['carrera'] : $perfil['carrera'];
        $perfil['universidad'] = isset($_GET['universidad']) && $_GET['universidad'] !== '' ? $_GET['universidad'] : $perfil['universidad'];
        $perfil['ciudad'] = isset($_GET['ciudad']) && $_GET['ciudad'] !== '' ? $_GET['ciudad'] : $perfil['ciudad'];
        $perfil['email'] = isset($_GET['email']) && $_GET['email'] !== '' ? $_GET['email'] : $perfil['email'];
        $perfil['telefono'] = isset($_GET['telefono']) && $_GET['telefono'] !== '' ? $_GET['telefono'] : $perfil['telefono'];
        $perfil['opcion'] = isset($_GET['opcion']) ? $_GET['opcion'] : $perfil['opcion'];

        $_SESSION['perfil'] = $perfil;
        $_SESSION['flash'] = ['type' => 'updated'];

        $ruta = strtok($_SERVER['REQUEST_URI'], '?');
        header("Location: {$ruta}", true, 302); // redirige sin parámetros
        exit;

    } elseif ($accion === 'restablecer') {
        $_SESSION['perfil'] = $defaults;
        $_SESSION['flash'] = ['type' => 'reset'];

        $ruta = strtok($_SERVER['REQUEST_URI'], '?');
        header("Location: {$ruta}", true, 302);
        exit;
    }
}

// Preparar datos para render
$perfil = $_SESSION['perfil'];
$mi_nombre = $perfil['nombre'];
$fecha_nacimiento = $perfil['fecha_nacimiento'];
$mi_carrera = $perfil['carrera'];
$mi_universidad = $perfil['universidad'];
$mi_ciudad = $perfil['ciudad'];
$mi_email = $perfil['email'];
$mi_telefono = $perfil['telefono'];
$opcion = $perfil['opcion'];

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$edad_exacta = calcular_edad_exacta($fecha_nacimiento);
$dias_cumple = dias_hasta_cumpleanos($fecha_nacimiento);
$mensaje_edad = ($edad_exacta['años'] >= 18)
    ? "Excelente, tienes {$edad_exacta['años']} y eres mayor de edad."
    : "Lo siento, tienes {$edad_exacta['años']} y eres menor de edad.";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>👤 Panel de Información Personal - PHP</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: Arial, sans-serif; background: linear-gradient(135deg, #667eea, #764ba2); min-height:100vh; padding:20px; }
        .container { max-width: 800px; margin: 0 auto; }
        .header { text-align:center; color:#fff; margin-bottom:30px; padding:25px; background:rgba(255,255,255,0.1); border-radius:20px; backdrop-filter: blur(10px); }
        .panel-info, .formulario { background:#fff; padding:30px; border-radius:20px; box-shadow:0 15px 35px rgba(0,0,0,0.2); margin-bottom:30px; }
        .panel-info h2, .formulario h2 { text-align:center; border-bottom:3px solid #007bff; padding-bottom:15px; margin-bottom:25px; color:#333; }
        .info-grid { display:grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap:20px; }
        .dato { background: linear-gradient(135deg, #f8f9fa, #e9ecef); padding:20px; border-radius:12px; border-left:5px solid #007bff; }
        .dato-label { font-weight:bold; color:#555; font-size:14px; margin-bottom:8px; display:block; }
        .dato-valor { font-size:18px; color:#333; font-weight:600; }
        .edad-especial { background: linear-gradient(135deg, #e8f5e8, #c8e6c9); border-left-color:#4caf50; text-align:center; }
        .edad-numero { font-size:2.5em; font-weight:bold; color:#2e7d32; display:block; margin:10px 0; }
        .edad-detalle { font-size:14px; color:#666; margin-top:8px; }
        .botones { display:flex; gap:15px; justify-content:center; flex-wrap:wrap; margin-top:25px; }
        .btn { padding:15px 30px; border:none; border-radius:12px; font-size:16px; font-weight:bold; cursor:pointer; }
        .btn-actualizar { background: linear-gradient(135deg, #28a745, #20c997); color:#fff; }
        .btn-restablecer { background: linear-gradient(135deg, #6c757d, #495057); color:#fff; }
        .mensaje { padding:20px; border-radius:12px; margin-bottom:20px; text-align:center; font-weight:bold; }
        .exito { background: linear-gradient(135deg, #d4edda, #c3e6cb); border:3px solid #28a745; color:#155724; }
        .info { background: linear-gradient(135deg, #d1ecf1, #bee5eb); border:3px solid #17a2b8; color:#0c5460; }
        .fecha-actualizacion { text-align:center; color:#007bff; font-weight:bold; margin-top:10px; }
        @media (max-width:600px){ .info-grid{grid-template-columns:1fr;} }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>👤 Panel de Información Personal</h1>
        <p>Sesiones + método GET con redirección limpia</p>
    </div>

    <?php if ($flash && $flash['type']==='updated'): ?>
        <div class="mensaje exito">✅ ¡Información actualizada correctamente!</div>
    <?php elseif ($flash && $flash['type']==='reset'): ?>
        <div class="mensaje info">♻️ Información restablecida a valores por defecto.</div>
    <?php endif; ?>

    <div class="panel-info">
        <h2>📋 Mi Información Personal</h2>
        <div class="info-grid">
            <div class="dato">
                <span class="dato-label">👤 Nombre Completo</span>
                <span class="dato-valor"><?php echo htmlspecialchars($mi_nombre); ?></span>
            </div>

            <div class="dato edad-especial">
                <span class="dato-label">🗓️ Edad</span>
                <span class="edad-numero"><?php echo $edad_exacta['años']; ?> años</span>
                <div class="edad-detalle">
                    <?php echo $edad_exacta['meses']; ?> meses y <?php echo $edad_exacta['dias']; ?> días<br>
                    <small>Total: <?php echo number_format($edad_exacta['total_dias']); ?> días de vida</small><br>
                    <small><?php echo htmlspecialchars($mensaje_edad); ?></small>
                </div>
            </div>

            <div class="dato">
                <span class="dato-label">📅 Fecha de Nacimiento</span>
                <span class="dato-valor"><?php echo date('d/m/Y', strtotime($fecha_nacimiento)); ?></span>
                <div class="edad-detalle">
                    <?php echo date('l', strtotime($fecha_nacimiento)); ?> - 
                    Próximo cumpleaños en <?php echo $dias_cumple; ?> días
                </div>
            </div>

            <div class="dato">
                <span class="dato-label">🎓 Carrera</span>
                <span class="dato-valor"><?php echo htmlspecialchars($mi_carrera); ?></span>
            </div>

            <div class="dato">
                <span class="dato-label">🏫 Universidad</span>
                <span class="dato-valor"><?php echo htmlspecialchars($mi_universidad); ?></span>
            </div>

            <div class="dato">
                <span class="dato-label">📍 Ciudad</span>
                <span class="dato-valor"><?php echo htmlspecialchars($mi_ciudad); ?></span>
            </div>

            <div class="dato">
                <span class="dato-label">📧 Email</span>
                <span class="dato-valor"><?php echo htmlspecialchars($mi_email); ?></span>
            </div>

            <div class="dato">
                <span class="dato-label">📞 Teléfono</span>
                <span class="dato-valor"><?php echo htmlspecialchars($mi_telefono); ?></span>
            </div>

            <div class="dato">
                <span class="dato-label">⚧️ Género</span>
                <span class="dato-valor">
                    <?php echo $opcion !== '' ? htmlspecialchars($opcion) : 'No se ha seleccionado el género.'; ?>
                </span>
            </div>
        </div>

        <div class="fecha-actualizacion">
            📊 Información actualizada el: <?php echo date('d/m/Y H:i:s'); ?>
        </div>
    </div>

    <div class="formulario">
        <h2>✏️ Editar Información</h2>
        <form method="GET">
            <div class="info-grid">
                <div class="dato">
                    <label class="dato-label" for="nombre">👤 Nombre Completo</label>
                    <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($mi_nombre); ?>" required>
                </div>

                <div class="dato">
                    <label class="dato-label" for="fecha_nacimiento">🎂 Fecha de Nacimiento</label>
                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo htmlspecialchars($fecha_nacimiento); ?>" required>
                </div>

                <div class="dato">
                    <label class="dato-label" for="carrera">🎓 Carrera</label>
                    <input type="text" id="carrera" name="carrera" value="<?php echo htmlspecialchars($mi_carrera); ?>" required>
                </div>

                <div class="dato">
                    <label class="dato-label" for="universidad">🏫 Universidad</label>
                    <input type="text" id="universidad" name="universidad" value="<?php echo htmlspecialchars($mi_universidad); ?>" required>
                </div>

                <div class="dato">
                    <label class="dato-label" for="ciudad">📍 Ciudad</label>
                    <input type="text" id="ciudad" name="ciudad" value="<?php echo htmlspecialchars($mi_ciudad); ?>" required>
                </div>

                <div class="dato">
                    <label class="dato-label" for="email">📧 Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($mi_email); ?>" required>
                </div>

                <div class="dato">
                    <label class="dato-label" for="telefono">📞 Teléfono</label>
                    <input type="tel" id="telefono" name="telefono" value="<?php echo htmlspecialchars($mi_telefono); ?>" required>
                </div>

                <div class="dato">
                    <label class="dato-label">⚧️ Género</label>
                    <label><input type="radio" name="opcion" value="Masculino" <?php if($opcion==="Masculino") echo "checked"; ?>> Masculino</label><br>
                    <label><input type="radio" name="opcion" value="Femenino" <?php if($opcion==="Femenino") echo "checked"; ?>> Femenino</label>
                </div>
            </div>

            <div class="botones">
                <button type="submit" name="accion" value="actualizar" class="btn btn-actualizar">🔄 Actualizar</button>
                <button type="submit" name="accion" value="restablecer" class="btn btn-restablecer">♻️ Restablecer</button>
            </div>
        </form>
    </div>

    <div class="info-sistema dato" style="text-align:center;">
        <p>🐘 <strong>PHP <?php echo PHP_VERSION; ?></strong> — 🌐 <?php echo PHP_OS; ?> — ⏰ <?php echo date('H:i:s'); ?></p>
    </div>
</div>
</body>
</html>
