<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 1: Variables Básicas</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 2.2em;
            margin-bottom: 10px;
        }

        .header p {
            font-size: 1.1em;
            opacity: 0.9;
        }

        .content {
            padding: 30px;
        }

        .difficulty {
            display: inline-block;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 20px;
            background: #dcfce7;
            color: #166534;
        }

        .objective {
            background: #f8fafc;
            border-left: 5px solid #4f46e5;
            padding: 20px;
            margin-bottom: 25px;
            border-radius: 8px;
        }

        .objective h3 {
            color: #1e293b;
            margin-bottom: 15px;
            font-size: 1.3em;
        }

        .instructions {
            margin-bottom: 25px;
        }

        .instructions h4 {
            color: #374151;
            margin-bottom: 15px;
            font-size: 1.1em;
        }

        .instructions ul {
            padding-left: 20px;
        }

        .instructions li {
            margin-bottom: 8px;
            line-height: 1.6;
        }

        .code-input {
            width: 100%;
            min-height: 200px;
            padding: 20px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            resize: vertical;
            transition: all 0.3s ease;
            background: #f8fafc;
        }

        .code-input:focus {
            outline: none;
            border-color: #4f46e5;
            background: white;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .buttons {
            display: flex;
            gap: 15px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .btn {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background: linear-gradient(135deg, #3730a3, #6b21a8);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #06b6d4, #0891b2);
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #0891b2, #0e7490);
        }

        .tips {
            background: #fffbeb;
            border: 1px solid #f59e0b;
            border-radius: 10px;
            padding: 20px;
            margin-top: 25px;
        }

        .tips h4 {
            color: #92400e;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .tips ul {
            color: #92400e;
            padding-left: 20px;
        }

        .tips li {
            margin-bottom: 8px;
        }

        .nav-link {
            /* Estilos removidos - ya no se usan */
        }

        code {
            background: #e5e7eb;
            padding: 3px 6px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            color: #374151;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📝 Ejercicio 1: Variables Básicas</h1>
            <p>Aprende a declarar variables y trabajar con tipos de datos</p>
        </div>

        <div class="content">
            <span class="difficulty">🟢 FÁCIL</span>

            <div class="objective">
                <h3>🎯 Objetivo</h3>
                <p>Crear variables con diferentes tipos de datos y mostrar su información usando <code>gettype()</code>.</p>
            </div>

            <div class="instructions">
                <h4>📋 Instrucciones:</h4>
                <ul>
                    <li>Declara una variable <code>$miNombre</code> con tu nombre</li>
                    <li>Declara una variable <code>$miEdad</code> con tu edad</li>
                    <li>Declara una variable <code>$salario</code> con un valor decimal</li>
                    <li>Declara una variable <code>$esTrabajador</code> con valor <code>true</code></li>
                    <li>Muestra todas las variables con <code>echo</code> y usa <code>gettype()</code> para mostrar su tipo</li>
                </ul>
            </div>

            <textarea class="code-input" placeholder="Escribe tu código PHP aquí (sin las etiquetas <?php ?>)..."></textarea>

            <div class="buttons">
                <button class="btn" onclick="runExercise()">▶ Ejecutar Código</button>
            </div>

            <div class="tips">
                <h4>💡 Consejos importantes:</h4>
                <ul>
                    <li>Las variables en PHP siempre empiezan con el símbolo <code>$</code></li>
                    <li>PHP es sensible a mayúsculas y minúsculas en nombres de variables</li>
                    <li>Usa <code>gettype($variable)</code> para obtener el tipo de dato</li>
                    <li>Los strings van entre comillas simples o dobles</li>
                    <li>Para mostrar booleanos usa el operador ternario: <code>$bool ? 'Sí' : 'No'</code></li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        const solution = ``; // Solución removida

        function runExercise() {
            const code = document.querySelector('.code-input').value.trim();

            if (!code) {
                alert('⚠️ Por favor, escribe algún código para ejecutar.');
                return;
            }

            try {
                const output = simulatePHP(code);
                alert(`🚀 RESULTADO DEL EJERCICIO 1

${output}`);
                
                // Marcar como completado
                markAsCompleted();
            } catch (error) {
                alert(`❌ ERROR EN EL CÓDIGO

${error.message}

Revisa tu código e intenta nuevamente.`);
            }
        }

        function simulatePHP(code) {
            // Extraer y mostrar valores de variables
            const variables = extractVariables(code);
            if (variables.length > 0) {
                let output = '📊 VARIABLES DECLARADAS:\n';
                variables.forEach(variable => {
                    output += `• ${variable.name}: ${variable.value} (${variable.type})\n`;
                });
                return output;
            } else {
                return '⚠️ No se detectaron variables en tu código.\nAsegúrate de usar la sintaxis: $variable = valor;';
            }
        }

        function extractVariables(code) {
            const variables = [];
            const lines = code.split('\n');
            
            lines.forEach(line => {
                line = line.trim();
                
                // Buscar declaraciones de variables
                const varPattern = /\$(\w+)\s*=\s*(.+);/;
                const match = line.match(varPattern);
                
                if (match) {
                    const varName = '$' + match[1];
                    let value = match[2].trim();
                    let type = 'unknown';
                    
                    // Determinar tipo y valor
                    if (value === 'true') {
                        type = 'boolean';
                        value = 'true';
                    } else if (value === 'false') {
                        type = 'boolean';
                        value = 'false';
                    } else if (value.match(/^["'].*["']$/)) {
                        type = 'string';
                        value = value.replace(/^["']|["']$/g, '');
                    } else if (value.match(/^\d+$/)) {
                        type = 'integer';
                    } else if (value.match(/^\d+\.\d+$/)) {
                        type = 'float';
                    }
                    
                    variables.push({ name: varName, value: value, type: type });
                }
            });
            
            return variables;
        }

        // Eliminar función showHint() ya no se usa

        function markAsCompleted() {
            // Función simplificada sin localStorage
        }

        function goToExercise(num) {
            // Función removida - ya no se usa
        }
    </script>
</body>
</html>