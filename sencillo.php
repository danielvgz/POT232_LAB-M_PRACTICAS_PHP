<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculador de Edad</title>
</head>
<body>
    <h1>Calculador de Edad</h1>
    
    <form id="formEdad">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        <br><br>
        
        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" required>
        <br><br>
        
        <label for="fechaNacimiento">Fecha de Nacimiento:</label>
        <input type="date" id="fechaNacimiento" name="fechaNacimiento" required>
        <br><br>
        
        <button type="button" onclick="validar()">Validar</button>
    </form>

    <script>
        function validar() {
            // Obtener valores del formulario
            const nombre = document.getElementById('nombre').value;
            const correo = document.getElementById('correo').value;
            const fechaNacimiento = document.getElementById('fechaNacimiento').value;
            
            // Validar que todos los campos estén llenos
            if (!nombre || !correo || !fechaNacimiento) {
                alert('Por favor, completa todos los campos.');
                return;
            }
            
            // Calcular la edad
            const edad = calcularEdad(fechaNacimiento);
            
            // Mostrar resultado en alerta
            alert(`Hola ${nombre}!\n\nTu edad es: ${edad} años\n\nCorreo registrado: ${correo}`);
        }
        
        function calcularEdad(fechaNacimiento) {
            // Obtener fecha actual
            const fechaActual = new Date();
            
            // Convertir fecha de nacimiento a objeto Date
            const fechaNac = new Date(fechaNacimiento);
            
            // Calcular diferencia en años
            let edad = fechaActual.getFullYear() - fechaNac.getFullYear();
            
            // Ajustar si aún no ha cumplido años este año
            const mesActual = fechaActual.getMonth();
            const diaActual = fechaActual.getDate();
            const mesNacimiento = fechaNac.getMonth();
            const diaNacimiento = fechaNac.getDate();
            
            if (mesActual < mesNacimiento || (mesActual === mesNacimiento && diaActual < diaNacimiento)) {
                edad--;
            }
            
            return edad;
        }
    </script>
</body>
</html>