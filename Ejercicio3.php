<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 3: Conversión de Tipos</title>
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
            background: linear-gradient(135deg, #f59e0b, #d97706);
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
            background: #fef3c7;
            color: #92400e;
        }

        .objective {
            background: #fffbeb;
            border-left: 5px solid #f59e0b;
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
            border-color: #f59e0b;
            background: white;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
        }

        .buttons {
            display: flex;
            gap: 15px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .btn {
            background: linear-gradient(135deg, #f59e0b, #d97706);
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
            background: linear-gradient(135deg, #d97706, #b45309);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .casting-guide {
            background: #fef3c7;
            border: 1px solid #f59e0b;
            border-radius: 10px;
            padding: 20px;
            margin-top: 25px;
        }

        .casting-guide h4 {
            color: #92400e;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .casting-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .casting-item {
            background: white;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #fde68a;
        }

        .casting-symbol {
            font-size: 1.2em;
            font-weight: bold;
            color: #d97706;
            margin-bottom: 5px;
            font-family: 'Courier New', monospace;
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
            <h1>🔄 Ejercicio 3: Conversión de Tipos</h1>
            <p>Aprende el casting entre diferentes tipos de datos</p>
        </div>

        <div class="content">
            <span class="difficulty">🟡 MEDIO</span>

            <div class="objective">
                <h3>🎯 Objetivo</h3>
                <p>Practicar el casting (conversión) entre diferentes tipos de datos en PHP y observar cómo cambian los valores y tipos.</p>
            </div>

            <div class="instructions">
                <h4>📋 Instrucciones:</h4>
                <ul>
                    <li>Declara <code>$texto = "123.45"</code></li>
                    <li>Convierte a entero usando <code>(int)</code> y muestra el resultado y su tipo</li>
                    <li>Convierte a float usando <code>(float)</code> y muestra el resultado y su tipo</li>
                    <li>Declara <code>$numero = 42</code> y conviértelo a string</li>
                    <li>Declara <code>$booleano = false</code> y conviértelo a entero</li>
                    <li>Usa <code>gettype()</code> para verificar cada tipo después de la conversión</li>
                </ul>
            </div>

            <textarea class="code-input" placeholder="Escribe tu código PHP aquí (sin las etiquetas <?php ?>)..."></textarea>

            <div class="buttons">
                <button class="btn" onclick="runExercise()">▶ Ejecutar Código</button>
            </div>

            <div class="casting-guide">
                <h4>🔧 Operadores de Casting en PHP:</h4>
                <div class="casting-grid">
                    <div class="casting-item">
                        <div class="casting-symbol">(int)</div>
                        <div><strong>A entero:</strong> (int)$variable</div>
                    </div>
                    <div class="casting-item">
                        <div class="casting-symbol">(float)</div>
                        <div><strong>A decimal:</strong> (float)$variable</div>
                    </div>
                    <div class="casting-item">
                        <div class="casting-symbol">(string)</div>
                        <div><strong>A texto:</strong> (string)$variable</div>
                    </div>
                    <div class="casting-item">
                        <div class="casting-symbol">(bool)</div>
                        <div><strong>A booleano:</strong> (bool)$variable</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function runExercise() {
            const code = document.querySelector('.code-input').value.trim();

            if (!code) {
                alert('⚠️ Por favor, escribe algún código para ejecutar.');
                return;
            }

            try {
                const output = simulatePHP(code);
                alert(`🔄 RESULTADO DEL EJERCICIO 3

${output}`);
                
                markAsCompleted();
            } catch (error) {
                alert(`❌ ERROR EN EL CÓDIGO

${error.message}

Revisa tu código e intenta nuevamente.`);
            }
        }

        function simulatePHP(code) {
            const variables = extractVariables(code);
            const conversions = extractConversions(code);
            
            if (variables.length > 0 || conversions.length > 0) {
                let output = '';
                
                if (variables.length > 0) {
                    output += '📊 VARIABLES DECLARADAS:\n';
                    variables.forEach(variable => {
                        output += `• ${variable.name}: ${variable.value} (${variable.type})\n`;
                    });
                    output += '\n';
                }
                
                if (conversions.length > 0) {
                    output += '🔄 CONVERSIONES DETECTADAS:\n';
                    conversions.forEach(conversion => {
                        output += `• ${conversion}\n`;
                    });
                }
                
                return output || '⚠️ No se detectaron variables o conversiones en tu código.';
            } else {
                return '⚠️ No se detectaron variables o conversiones en tu código.\nAsegúrate de usar casting como: (int)$variable';
            }
        }

        function extractVariables(code) {
            const variables = [];
            const lines = code.split('\n');
            
            lines.forEach(line => {
                line = line.trim();
                const varPattern = /\$(\w+)\s*=\s*(.+);/;
                const match = line.match(varPattern);
                
                if (match && !line.includes('(int)') && !line.includes('(float)') && !line.includes('(string)') && !line.includes('(bool)')) {
                    const varName = '$' + match[1];
                    let value = match[2].trim();
                    let type = 'unknown';
                    
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

        function extractConversions(code) {
            const conversions = [];
            const lines = code.split('\n');
            
            lines.forEach(line => {
                line = line.trim();
                
                // Detectar conversiones de tipo
                if (line.includes('(int)')) {
                    conversions.push('Conversión a integer detectada');
                }
                if (line.includes('(float)')) {
                    conversions.push('Conversión a float detectada');
                }
                if (line.includes('(string)')) {
                    conversions.push('Conversión a string detectada');
                }
                if (line.includes('(bool)')) {
                    conversions.push('Conversión a boolean detectada');
                }
            });
            
            return conversions;
        }

        function markAsCompleted() {
            // Función simplificada
        }
    </script>
</body>
</html>