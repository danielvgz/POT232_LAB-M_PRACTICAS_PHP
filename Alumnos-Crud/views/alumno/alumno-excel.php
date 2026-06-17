<html>
    <head>
        <meta charset="utf-8" />
    </head>
    <body>
        <?php
        $valor = static function ($row, $campo, $fallback = '') {
            if (is_object($row) && method_exists($row, '__GET')) {
                $dato = $row->__GET($campo);
                return $dato !== null ? $dato : $fallback;
            }

            return $row->$campo ?? $fallback;
        };
        ?>
        <table>
            <thead>
                <tr style="background:#eee;">
                    <th style="width:180px;">Nombre</th>
                    <th>Apellido</th>
                    <th>Correo</th>
                    <th>Matrícula</th>
                    <th>Docente</th>
                    <th>Créditos</th>
                    <th style="width:120px;">Sexo</th>
                    <th style="width:120px;">Nacimiento</th>
                </tr>
            </thead>
            <?php foreach(($alumnosExport ?? []) as $r): ?>
                <tr>
                    <td><?php echo htmlspecialchars((string)$valor($r, 'Nombre', $valor($r, 'nombre_alumno', ''))); ?></td>
                    <td><?php echo htmlspecialchars((string)$valor($r, 'Apellido', $valor($r, 'apellido_alumno', ''))); ?></td>
                    <td><?php echo htmlspecialchars((string)$valor($r, 'Correo', $valor($r, 'correo_alumno', ''))); ?></td>
                    <td><?php echo htmlspecialchars((string)$valor($r, 'nombre_asignacion', '')); ?></td>
                    <td><?php echo htmlspecialchars(trim((string)$valor($r, 'nombre_docente', '') . ' ' . (string)$valor($r, 'apellido_docente', ''))); ?></td>
                    <td><?php echo htmlspecialchars((string)$valor($r, 'creditos', '')); ?></td>
                    <td><?php echo (string)$valor($r, 'Sexo', '') === '1' ? 'Hombre' : ((string)$valor($r, 'Sexo', '') === '2' ? 'Mujer' : ''); ?></td>
                    <td><?php echo htmlspecialchars((string)$valor($r, 'FechaNacimiento', '')); ?></td>
                </tr>
            <?php endforeach; ?>
        </table> 
    </body>
</html>
