CRUD en PHP + MySQL

Instrucciones rápidas:

1) MySQL (recomendado)

   - Ejecuta `mysql -u root -p < schema.sql` para crear la base de datos `examen` y la tabla `personas`.
   - Ajusta el usuario/contraseña según tu entorno o usa variables de entorno descritas abajo.

2) SQLite (opcional para pruebas)

   - El proyecto incluye soporte para SQLite en `db.php`, que creará `database.sqlite` dentro de la carpeta `crud_php_mysql` automáticamente si se usa.
   - Si usas SQLite, la tabla por defecto creada será `personas` y se insertan datos de ejemplo al primer acceso.

3) Seleccionar driver

   - El proyecto está configurado para usar MySQL por defecto. Ajusta `db_mysql.php` o las variables de entorno si hace falta.

4) Variables de entorno para MySQL

   - `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`, `DB_CHARSET`.

5) Ejecutar PHP embebido para probar (desde la carpeta `crud_php_mysql`):

   php -S 127.0.0.1:8000

   Abrir en el navegador: http://127.0.0.1:8000/index.php

Notas:
- Usa PDO con sentencias preparadas para prevenir inyección SQL.
- Este ejemplo es simple y pensado para aprender; en producción añade validación, autenticación y manejo de errores más robusto.
