-- Script para poblar la tabla usuarios con datos de alumnos
-- La contraseña será el primer nombre (en minúsculas, sin espacios) seguido de 123, por ejemplo: maria123
-- Si el usuario ya existe (por correo), NO lo duplicará

INSERT INTO usuarios (correo, password)
SELECT 
    a.Correo,
    CONCAT(LOWER(SUBSTRING_INDEX(a.Nombre,' ',1)), '123') AS password
FROM alumnos a
LEFT JOIN usuarios u ON a.Correo = u.correo
WHERE u.correo IS NULL;
