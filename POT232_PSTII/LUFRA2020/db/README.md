# Esquema de base de datos - Nóminas (Payroll)

Este directorio contiene un esquema SQL portable para un sistema de nóminas básico.

Archivos:

- `schema.sql` : DDL (comentado) diseñado para ser portable entre motores (Postgres, MySQL, SQLite). Contiene tablas principales, índices y ejemplos de inserción.

Cómo usar

1. Revisa `schema.sql` y, si tu base de datos lo requiere, actualiza las columnas PK para usar la sintaxis de auto-increment apropiada (por ejemplo `SERIAL` en Postgres, `AUTO_INCREMENT` en MySQL).

2. Ejecuta el script en tu base de datos. Ejemplos:

   - PostgreSQL:

     psql -d tu_base -f POT232_PSTII/db/schema.sql

   - MySQL:

     mysql -u user -p tu_base < POT232_PSTII/db/schema.sql

3. Ajusta y extiende el esquema según necesidades (por ejemplo, tablas para contratos temporales, control horario, centros de costo).

Buenas prácticas y siguientes pasos

- Usa migrations (Flyway, Phinx, Laravel migrations, Doctrine Migrations) para versionar cambios.
- No almacenes contraseñas en texto plano; aquí usamos `password_hash` en la capa de aplicación.
- Mantén los tipos y tasas aplicadas en cada `payslip_item` si necesitas reproducir recibos antiguos.
- Para producción, considera usar una base de datos relacional como PostgreSQL y crear funciones/transactions que encapsulen el cálculo de cada nómina.

Si quieres, puedo:

- Generar un script de migración listo para Postgres o MySQL.
- Crear una pequeña API/PHP que use este esquema para crear empleados, contratos y generar un payslip de ejemplo.
- Añadir campos adicionales (por ejemplo `applied_tax_rate` en `payslip_items`) para soportar trazabilidad de cálculos.
