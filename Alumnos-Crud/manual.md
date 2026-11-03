# Manual de Usuario - Sistema de Gestión Escolar

Este sistema permite gestionar la información de Alumnos, Docentes y sus inscripciones/matrículas.

## Acceso al Sistema

1. Accede mediante la pantalla de login en:
   ```
   Alumnos-Crud/login.php
   ```
   - Usuario: **admin**
   - Contraseña: **password123**

2. Al iniciar sesión verás un menú principal con enlaces a los módulos principales:

### Módulos del sistema

- **Alumnos:**  
  Ruta: `Alumnos-Crud/index.php`  
  Permite registrar, consultar, modificar y eliminar alumnos.

- **Docentes:**  
  Ruta: `Alumnos-Crud/Docentes/index.php`  
  Permite registrar, consultar, modificar y eliminar docentes.

- **Inscripciones:**  
  Ruta: `Alumnos-Crud/Inscripciones/index.php`  
  Permite realizar inscripciones o asignaciones (ej. docentes a materias o alumnos a cursos).

3. Para cerrar sesión, usa el enlace:
   ```
   Alumnos-Crud/logout.php
   ```

---

**Nota:**  
Todos los módulos requieren estar autenticado. Si intentas acceder sin login, serás redirigido.