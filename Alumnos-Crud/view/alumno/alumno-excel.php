<html>
    <head>
        <meta charset="utf-8" />
    </head>
    <body>
        <table>
            <thead>
                <tr style="background:#eee;">
                    <th style="width:180px;">Nombre</th>
                    <th>Apellido</th>
                    <th>Correo</th>
                    <th style="width:120px;">Sexo</th>
                    <th style="width:120px;">Nacimiento</th>
                </tr>
            </thead>
            <?php foreach($this->model->Listar() as $r): ?>
                <tr>
                    <td><?php echo $r->__GET('Nombre'); ?></td>
                    <td><?php echo $r->__GET('Apellido'); ?></td>
                    <td><?php echo $r->__GET('Correo'); ?></td>
                    <td><?php echo $r->__GET('Sexo') == 1 ? 'Hombre' : 'Mujer'; ?></td>
                    <td><?php echo $r->__GET('FechaNacimiento'); ?></td>
                </tr>
            <?php endforeach; ?>
        </table> 
    </body>
</html>