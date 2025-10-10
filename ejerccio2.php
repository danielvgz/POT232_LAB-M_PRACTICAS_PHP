<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>👤 Panel de Información Personal - PHP</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .header {
            text-align: center;
            color: white;
            margin-bottom: 30px;
            padding: 25px;
            background: rgba(255,255,255,0.1);
            border-radius: 20px;
            backdrop-filter: blur(10px);
        }
        
        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .panel-info {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            margin-bottom: 30px;
            transition: transform 0.3s ease;
        }
        
        .panel-info:hover {
            transform: translateY(-5px);
        }
        
        .panel-info h2 {
            color: #333;
            border-bottom: 3px solid #007bff;
            padding-bottom: 15px;
            margin-bottom: 25px;
            font-size: 1.8em;
            text-align: center;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .dato {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 20px;
            border-radius: 12px;
            border-left: 5px solid #007bff;
            transition: all 0.3s ease;
        }
        
        .dato:hover {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            border-left-color: #2196f3;
            transform: translateX(5px);
        }
        
        .dato-label {
            font-weight: bold;
            color: #555;
            font-size: 14px;
            margin-bottom: 8px;
            display: block;
        }
        
        .dato-valor {
            font-size: 18px;
            color: #333;
            font-weight: 600;
        }
        
        .edad-especial {
            background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c9 100%);
            border-left-color: #4caf50;
            text-align: center;
        }
        
        .edad-numero {
            font-size: 2.5em;
            font-weight: bold;
            color: #2e7d32;
            display: block;
            margin: 10px 0;
        }
        
        .edad-detalle {
            font-size: 14px;
            color: #666;
            margin-top: 8px;
        }
        
        .formulario {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        }
        
        .formulario h2 {
            color: #333;
            border-bottom: 3px solid #28a745;
            padding-bottom: 15px;
            margin-bottom: 25px;
            font-size: 1.8em;
            text-align: center;
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
        }
        
        .form-group label {
            font-weight: bold;
            color: #333;
            margin-bottom: 8px;
            font-size: 15px;
        }
        
        .form-group input {
            padding: 15px;
            border: 2px solid #ddd;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #fafafa;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #007bff;
            background: white;
            box-shadow: 0 0 0 4px rgba(0,123,255,0.1);
        }
        
        .form-group input:valid {
            border-color: #28a745;
        }
        
        .botones {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 25px;
        }
        
        .btn {
            padding: 15px 30px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 150px;
        }
        
        .btn-actualizar {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }
        
        .btn-actualizar:hover {
            background: linear-gradient(135deg, #218838, #1ba085);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(40,167,69,0.4);
        }
        
        .btn-restablecer {
            background: linear-gradient(135deg, #6c757d, #495057);
            color: white;
        }
        
        .btn-restablecer:hover {
            background: linear-gradient(135deg, #5a6268, #343a40);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(108,117,125,0.4);
        }
        
        .mensaje-exito {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            border: 3px solid #28a745;
            color: #155724;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
            animation: slideDown 0.5s ease;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .info-sistema {
            background: rgba(255,255,255,0.95);
            padding: 20px;
            border-radius: 12px;
            margin-top: 20px;
            text-align: center;
            color: #666;
        }
        
        .fecha-actualizacion {
            font-size: 14px;
            color: #007bff;
            font-weight: bold;
            margin-top: 10px;
        }
        
        @media (max-width: 600px) {
            .container {
                padding: 10px;
            }
            
            .header h1 {
                font-size: 2em;
            }
            
            .panel-info, .formulario {
                padding: 20px;
            }
            
            .info-grid, .form-grid {
                grid-template-columns: 1fr;
            }
            
            .botones {
                flex-direction: column;
                align-items: center;
            }
            
            .btn {
                width: 100%;
                max-width: 250px;
            }
        }
    </style>
</head>
<body>
    <?php
    // ===== CONFIGURACIÓN Y PROCESAMIENTO =====
    
    // Valores por defecto
    $defaults = array(
        'nombre' => 'Juan Carlos Pérez',
        'fecha_nacimiento' => '2002-03-15',
        'carrera' => 'Ingeniería en Sistemas',
        'universidad' => 'Universidad Tecnológica',
        'ciudad' => 'Ciudad de México',
        'email' => 'juan.carlos@email.com',
        'telefono' => '+52 55 1234-5678',
        
    );
    
    // Función para calcular edad exacta
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


    // Función para calcular días hasta cumpleaños
    function dias_hasta_cumpleanos($fecha_nacimiento) {
        $hoy = new DateTime();
        $cumple_este_año = new DateTime(date('Y') . substr($fecha_nacimiento, 4));
        
        if ($cumple_este_año < $hoy) {
            $cumple_este_año = new DateTime((date('Y') + 1) . substr($fecha_nacimiento, 4));
        }
        
        $diferencia = $hoy->diff($cumple_este_año);
        return $diferencia->days;
    }
    
    // Procesar formulario o usar valores por defecto
    $actualizado = false;
    
    if (isset($_GET['accion'])) {
        if ($_GET['accion'] === 'actualizar') {
            // Obtener datos del formulario
            $mi_nombre = isset($_GET['nombre']) && !empty($_GET['nombre']) ? $_GET['nombre'] : $defaults['nombre'];
            $fecha_nacimiento = isset($_GET['fecha_nacimiento']) && !empty($_GET['fecha_nacimiento']) ? $_GET['fecha_nacimiento'] : $defaults['fecha_nacimiento'];
            $mi_carrera = isset($_GET['carrera']) && !empty($_GET['carrera']) ? $_GET['carrera'] : $defaults['carrera'];
            $mi_universidad = isset($_GET['universidad']) && !empty($_GET['universidad']) ? $_GET['universidad'] : $defaults['universidad'];
            $mi_ciudad = isset($_GET['ciudad']) && !empty($_GET['ciudad']) ? $_GET['ciudad'] : $defaults['ciudad'];
            $mi_email = isset($_GET['email']) && !empty($_GET['email']) ? $_GET['email'] : $defaults['email'];
            $mi_telefono = isset($_GET['telefono']) && !empty($_GET['telefono']) ? $_GET['telefono'] : $defaults['telefono'];
            $opcion = isset($_GET['opcion']) && !empty($_GET['opcion']) ? $_GET['opcion'] : $defaults['opcion'];
            $actualizado = true;
        } elseif ($_GET['accion'] === 'restablecer') {
            // Usar valores por defecto
            $mi_nombre = $defaults['nombre'];
            $fecha_nacimiento = $defaults['fecha_nacimiento'];
            $mi_carrera = $defaults['carrera'];
            $mi_universidad = $defaults['universidad'];
            $mi_ciudad = $defaults['ciudad'];
            $mi_email = $defaults['email'];
            $mi_telefono = $defaults['telefono'];
            $opcion = isset($_GET['opcion']) && !empty($_GET['opcion']) ? $_GET['opcion'] : $defaults['opcion'];

        }
    } else {
        // Primera carga - usar valores por defecto
        $mi_nombre = $defaults['nombre'];
        $fecha_nacimiento = $defaults['fecha_nacimiento'];
        $mi_carrera = $defaults['carrera'];
        $mi_universidad = $defaults['universidad'];
        $mi_ciudad = $defaults['ciudad'];
        $mi_email = $defaults['email'];
        $mi_telefono = $defaults['telefono'];
    }
    
    // Calcular datos derivados
    $edad_exacta = calcular_edad_exacta($fecha_nacimiento);
    $dias_cumple = dias_hasta_cumpleanos($fecha_nacimiento);

    if ($edad_exacta >=18) {
         $mensaje_edad1= "excelente tienes $edad_exacta y eres mayor de edad"; }

        else {
            $mensaje_edad2="lo siento, tienes $edad_exacta y eres menor de edad";
        }
    
    

    ?>
    
    <div class="container">
        <!-- HEADER -->
        <div class="header">
            <h1>👤 Panel de Información Personal</h1>
            <p>Gestión dinámica con PHP - Actualización en tiempo real</p>
        </div>
        
        <!-- MENSAJE DE ÉXITO -->
        <?php if ($actualizado): ?>
        <div class="mensaje-exito">
            ✅ ¡Información actualizada correctamente!
            <br><small>Los cambios se han aplicado en tiempo real</small>
        </div>
        <?php endif; ?>
        
        <!-- PANEL DE INFORMACIÓN PERSONAL -->
        <div class="panel-info">
            <h2>📋 Mi Información Personal</h2>
            
            <div class="info-grid">
                <div class="dato">
                    <span class="dato-label">👤 Nombre Completo</span>
                    <span class="dato-valor"><?php echo htmlspecialchars($mi_nombre); ?></span>
                </div> <b> <?php echo $edad_exacta['años'].' años'; ?> <?php echo $edad_exacta['meses']; ?> meses y <?php echo $edad_exacta['dias'] ; 
                        ?> días </b>
                        <br><small>Total: <?php echo number_format($edad_exacta['total_dias']); ?> días de vida</small>
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
                    <span class="dato-label"> Genero</span>
                    <?php 
                        // Verifica si el parámetro 'opcion' está presente en la URL
                          if (isset($_GET['opcion'])) {
                                echo "El valor del parámetro 'genero' es: " . htmlspecialchars($_GET['opcion']);
                            } else {
                                echo "No se ha enviado el parámetro 'genero' por GET.";
                            }
                    ?>
                   
                </div>
            </div>
            
            <div class="fecha-actualizacion">
                📊 Información actualizada el: <?php echo date('d/m/Y H:i:s'); ?>
            </div>
        </div>
        
        <!-- FORMULARIO DE EDICIÓN -->
        <div class="formulario">
            <h2>✏️ Editar Información</h2>
            
            <form method="GET">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="nombre">👤 Nombre Completo</label>
                        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($mi_nombre); ?>" placeholder="Ingresa tu nombre completo" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="fecha_nacimiento">🎂 Fecha de Nacimiento</label>
                        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo $fecha_nacimiento; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="carrera">🎓 Carrera</label>
                        <input type="text" id="carrera" name="carrera" value="<?php echo htmlspecialchars($mi_carrera); ?>" placeholder="Tu carrera universitaria" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="universidad">🏫 Universidad</label>
                        <input type="text" id="universidad" name="universidad" value="<?php echo htmlspecialchars($mi_universidad); ?>" placeholder="Nombre de tu universidad" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="ciudad">📍 Ciudad</label>
                        <input type="text" id="ciudad" name="ciudad" value="<?php echo htmlspecialchars($mi_ciudad); ?>" placeholder="Tu ciudad actual" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">📧 Email</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($mi_email); ?>" placeholder="tu.email@ejemplo.com" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="telefono">📞 Teléfono</label>
                        <input type="tel" id="telefono" name="telefono" value="<?php echo htmlspecialchars($mi_telefono); ?>" placeholder="+52 55 1234-5678" required>
                    </div>
                        <!--Agregamos el form group para los inputs type "radio" -->
                    <div class="form-group">
                           <label for="genero"> Genero</label>
                          <label>
                           <input type="radio" name="opcion" value="Masculino" <?php if(isset($opcion) && $opcion=="Masculino") echo "checked"; ?>>
                           Masculino
                       </label>
                       <br>
                       <label>
                           <input type="radio" name="opcion" value="Femenino" <?php if(isset($opcion) && $opcion=="Femenino") echo "checked"; ?>>
                           Femenino
                       </label>
                     </div>
                    </div>
                </div>
                
                <div class="botones">
                    <button type="submit" name="accion" value="actualizar" class="btn btn-actualizar">
                        🔄 Actualizar
                    </button>
                    <button type="submit" name="accion" value="restablecer" class="btn btn-restablecer">
                        🔄 Restablecer
                    </button>
                </div>
            </form>
        </div>
        
        <!-- INFORMACIÓN DEL SISTEMA -->
        <div class="info-sistema">
            <p>🐘 <strong>Desarrollado con PHP <?php echo PHP_VERSION; ?></strong></p>
            <p>🌐 Sistema operativo: <?php echo PHP_OS; ?></p>
            <p>⏰ Hora del servidor: <?php echo date('H:i:s'); ?></p>
        </div>
    </div>
    
    <script>
        // Validación en tiempo real
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('input');
            
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    if (this.checkValidity() && this.value.length > 0) {
                        this.style.borderColor = '#28a745';
                        this.style.backgroundColor = '#f8fff8';
                    } else if (this.value.length > 0) {
                        this.style.borderColor = '#dc3545';
                        this.style.backgroundColor = '#fff8f8';
                    } else {
                        this.style.borderColor = '#ddd';
                        this.style.backgroundColor = '#fafafa';
                    }
                });
            });
            
            // Confirmación para restablecer
            const btnRestablecer = document.querySelector('button[value="restablecer"]');
            btnRestablecer.addEventListener('click', function(e) {
                if (!confirm('¿Estás seguro de que quieres restablecer toda la información a los valores por defecto?')) {
                    e.preventDefault();
                }
            });
        });
        
        // Efecto de éxito en el panel al actualizar
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('accion') === 'actualizar') {
                const panel = document.querySelector('.panel-info');
                panel.style.animation = 'slideDown 0.5s ease';
                
                // Scroll automático al panel actualizado
                setTimeout(() => {
                    panel.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }, 100);
            }
        });
    </script>
</body>
</html>
