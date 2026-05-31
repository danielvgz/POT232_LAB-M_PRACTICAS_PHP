# Escuela IT (MVC PHP + PDO)

Proyecto starter en `escuela_it` con MVC (`controllers/`, `models/`, `views/`), login por `correo` + `password`, CRUD de alumnos/docentes/materias/matriculas y PDO.

## Requisitos
- PHP 5.6+ / 7+
- MySQL Server 5.6.17 compatible
- IIS o Apache

## Base de datos
1. Crear base de datos `escuela_it`.
2. Ejecutar:

```sql
SOURCE database/schema.sql;
```

Usuarios de prueba:
- Alumno: `hitogoroshi@outlook.com` / `password`
- Maestro: `juan.perez@escuela.it` / `password`

## Configuración
Editar `config/database.php` o usar variables de entorno:
- `DB_HOST`
- `DB_NAME`
- `DB_USER`
- `DB_PASS`
- `DB_CHARSET`

## IIS
El archivo `web.config` enruta todas las peticiones a `index.php` (front controller) para que la app funcione en IIS.
