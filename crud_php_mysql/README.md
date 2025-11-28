CRUD en PHP + MySQL

Instrucciones rápidas:

1) MySQL (opcional)

   - Si prefieres MySQL, ejecuta `mysql -u root -p < schema.sql` para crear la base de datos y la tabla.
   - Ajusta el usuario/contraseña según tu entorno o usa variables de entorno descritas abajo.

2) SQLite (recomendado para pruebas rápidas)

   - El proyecto puede usar SQLite por defecto y creará `database.sqlite` dentro de la carpeta `crud_php_mysql` automáticamente.
   - No necesitas ejecutar `schema.sql` para usar SQLite; la tabla `users` se crea y se insertan datos de ejemplo al primer acceso.

3) Seleccionar driver

   - Para seleccionar MySQL exporta la variable de entorno `DB_DRIVER=mysql` antes de arrancar el servidor.
   - Para usar SQLite (por defecto) no hace falta cambiar nada.

4) Variables de entorno para MySQL

   - `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`, `DB_CHARSET`.

5) Ejecutar PHP embebido para probar (desde la carpeta `crud_php_mysql`):

   php -S 127.0.0.1:8000

   Abrir en el navegador: http://127.0.0.1:8000/index.php

Notas:
- Usa PDO con sentencias preparadas para prevenir inyección SQL.
- Este ejemplo es simple y pensado para aprender; en producción añade validación, autenticación y manejo de errores más robusto.
