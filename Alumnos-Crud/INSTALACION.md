# Manual de Instalación - Sistema de Gestión Escolar

Sigue estos pasos para instalar y poner en marcha el sistema en tu servidor local o de produccion.

## Requisitos

- Servidor web con PHP 7.x o superior
- Servidor MySQL/MariaDB
- Navegador web moderno

## Instrucciones

1. **Clona o descarga este repositorio.**

2. **Copia la carpeta `Alumnos-Crud` a tu directorio web (por ejemplo: `htdocs` para XAMPP, `www` en WAMP, etc).**

3. **Crea la base de datos.**
   - Accede a tu gestor de bases de datos (phpMyAdmin, MySQL Workbench, consola, etc).
   - Crea una base de datos con nombre, por ejemplo: `escuela`.
   - Importa el archivo `db.sql` incluido en la carpeta `Alumnos-Crud` para generar las tablas y datos iniciales.

4. **Configura la conexión a la base de datos.**
   - Edita el archivo de configuración (ejemplo: `config.php`) en `Alumnos-Crud` y establece los parámetros correctos de host, usuario, contraseña y base de datos.

5. **Acceso al sistema**
   - Abre tu navegador y entra a: `http://localhost/Alumnos-Crud/login.php`
   - Ingresa las credenciales:
     - Usuario: **admin**
     - Contraseña: **password123**

6. **Navega el sistema desde el menú principal tras hacer login.**

## Observaciones

- Las rutas internas y módulos están documentados en `manual.md`.
- Si tienes problemas de permisos en fotos/archivos, revisa los permisos de las carpetas en el servidor.