/*
  Esquema SQL para un sistema de nóminas básico.
  Este archivo utiliza SQL ANSI y es intencionalmente portable. Algunos motores
  (Postgres, MySQL, SQLite) requieren pequeñas variaciones para auto-increment
  o tipos JSON; consulta README.md en este directorio para notas específicas.

  Tablas principales:
   - empleados: información del trabajador
   - departamentos: departamentos / unidades
   - puestos: cargos
   - contratos: contratos / condiciones salariales
   - periodos_nomina: periodos de nómina (mensual/quincenal)
   - componentes_salario: conceptos de nómina (percepciones/deducciones)
   - recibos: recibos generados por empleado y periodo
   - lineas_recibo: líneas del recibo (salario base, horas extras, descuentos)
   - tasas_impuesto / contribuciones: tablas para impuestos y cotizaciones
   - pagos: registros de pago (transferencia, efectivo)
   - registro_auditoria: cambios / auditoría

  Recomendación: adapta los tipos `BIGINT`, `VARCHAR`, `DECIMAL` según el motor.
*/

-- Nota: para bases que no soporten AUTO_INCREMENT/SERIAL, usa la estrategia propia
-- (por ejemplo, SQLite INTEGER PRIMARY KEY AUTOINCREMENT, Postgres SERIAL/BIGSERIAL,
-- MySQL BIGINT AUTO_INCREMENT).

CREATE TABLE departamentos (
  id BIGINT PRIMARY KEY,
  codigo VARCHAR(32) UNIQUE,
  nombre VARCHAR(200) NOT NULL,
  descripcion VARCHAR(1000),
  id_responsable BIGINT,
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  actualizado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE puestos (
  id BIGINT PRIMARY KEY,
  departamento_id BIGINT REFERENCES departamentos(id) ON DELETE SET NULL,
  titulo VARCHAR(200) NOT NULL,
  descripcion VARCHAR(1000),
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  actualizado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE empleados (
  id BIGINT PRIMARY KEY,
  numero_empleado VARCHAR(64) UNIQUE,
  nombre VARCHAR(150) NOT NULL,
  apellido VARCHAR(150) NOT NULL,
  correo VARCHAR(250) UNIQUE,
  identificador_fiscal VARCHAR(100),
  fecha_nacimiento DATE,
  fecha_ingreso DATE,
  fecha_baja DATE,
  estado VARCHAR(32) DEFAULT 'activo', -- activo, suspendido, cesado
  telefono VARCHAR(50),
  direccion VARCHAR(500),
  banco VARCHAR(200),
  cuenta_bancaria VARCHAR(200),
  notas VARCHAR(2000),
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  actualizado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE contratos (
  id BIGINT PRIMARY KEY,
  empleado_id BIGINT NOT NULL REFERENCES empleados(id) ON DELETE CASCADE,
  puesto_id BIGINT REFERENCES puestos(id) ON DELETE SET NULL,
  fecha_inicio DATE NOT NULL,
  fecha_fin DATE,
  tipo_contrato VARCHAR(32) NOT NULL, -- p.ej. permanente, temporal, freelance
  frecuencia_pago VARCHAR(32) NOT NULL, -- mensual, quincenal, semanal
  salario_base DECIMAL(14,2) NOT NULL,
  moneda_pago VARCHAR(8) DEFAULT 'EUR',
  horas_por_semana DECIMAL(6,2),
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  actualizado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE periodos_nomina (
  id BIGINT PRIMARY KEY,
  codigo VARCHAR(64) UNIQUE,
  fecha_inicio DATE NOT NULL,
  fecha_fin DATE NOT NULL,
  estado VARCHAR(32) DEFAULT 'abierto', -- abierto, cerrado, pagado
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE componentes_salario (
  id BIGINT PRIMARY KEY,
  codigo VARCHAR(64) UNIQUE,
  nombre VARCHAR(200) NOT NULL,
  tipo VARCHAR(32) NOT NULL, -- percepcion, deduccion, cotizacion_empleador
  calculo VARCHAR(32) DEFAULT 'fijo', -- fijo, porcentaje, formula
  valor DECIMAL(14,4) DEFAULT 0.0, -- usado cuando calculo=fijo o porcentaje
  gravable BOOLEAN DEFAULT TRUE,
  visible_en_recibo BOOLEAN DEFAULT TRUE,
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE recibos (
  id BIGINT PRIMARY KEY,
  empleado_id BIGINT NOT NULL REFERENCES empleados(id) ON DELETE CASCADE,
  contrato_id BIGINT REFERENCES contratos(id) ON DELETE SET NULL,
  periodo_nomina_id BIGINT NOT NULL REFERENCES periodos_nomina(id) ON DELETE CASCADE,
  bruto DECIMAL(14,2) DEFAULT 0.00,
  total_percepciones DECIMAL(14,2) DEFAULT 0.00,
  total_deducciones DECIMAL(14,2) DEFAULT 0.00,
  neto DECIMAL(14,2) DEFAULT 0.00,
  estado VARCHAR(32) DEFAULT 'borrador', -- borrador, emitido, pagado
  emitido_en TIMESTAMP,
  pagado_en TIMESTAMP,
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  actualizado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE lineas_recibo (
  id BIGINT PRIMARY KEY,
  recibo_id BIGINT NOT NULL REFERENCES recibos(id) ON DELETE CASCADE,
  componente_id BIGINT REFERENCES componentes_salario(id) ON DELETE SET NULL,
  descripcion VARCHAR(500),
  importe DECIMAL(14,2) NOT NULL,
  porcentaje DECIMAL(10,4), -- si aplica (porcentaje)
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE tasas_impuesto (
  id BIGINT PRIMARY KEY,
  nombre VARCHAR(200) NOT NULL,
  porcentaje DECIMAL(6,4) NOT NULL,
  vigente_desde DATE,
  vigente_hasta DATE,
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE contribuciones (
  id BIGINT PRIMARY KEY,
  nombre VARCHAR(200) NOT NULL,
  tasa_empleado DECIMAL(6,4) DEFAULT 0.0,
  tasa_empleador DECIMAL(6,4) DEFAULT 0.0,
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE pagos (
  id BIGINT PRIMARY KEY,
  recibo_id BIGINT NOT NULL REFERENCES recibos(id) ON DELETE CASCADE,
  metodo VARCHAR(64) NOT NULL, -- transferencia_bancaria, efectivo, cheque
  importe DECIMAL(14,2) NOT NULL,
  pagado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  referencia VARCHAR(255),
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Registro de auditoría: payload puede ser TEXT para portabilidad; si la DB soporta JSON usa JSON/JSONB.
CREATE TABLE registro_auditoria (
  id BIGINT PRIMARY KEY,
  usuario_identificador VARCHAR(200),
  accion VARCHAR(100) NOT NULL,
  tabla VARCHAR(200),
  registro_id BIGINT,
  payload TEXT,
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Índices recomendados
CREATE INDEX idx_empleados_numero ON empleados(numero_empleado);
CREATE INDEX idx_empleados_correo ON empleados(correo);
CREATE INDEX idx_recibos_empleado_periodo ON recibos(empleado_id, periodo_nomina_id);
CREATE INDEX idx_periodos_fechas ON periodos_nomina(fecha_inicio, fecha_fin);

-- Ejemplo de datos iniciales (modifica AUTO_INCREMENT/serial según tu BD)
-- INSERT INTO departamentos (id, codigo, nombre) VALUES (1, 'RRHH', 'Recursos Humanos');
-- INSERT INTO puestos (id, departamento_id, titulo) VALUES (1, 1, 'Analista');
-- INSERT INTO empleados (id, numero_empleado, nombre, apellido, correo, fecha_ingreso, estado) VALUES (1, 'EMP001', 'Juan', 'Pérez', 'juan.perez@example.com', '2024-01-10', 'activo');
-- INSERT INTO contratos (id, empleado_id, puesto_id, fecha_inicio, tipo_contrato, frecuencia_pago, salario_base) VALUES (1,1,1,'2024-01-10','permanente','mensual',1500.00);

/*
  Notas específicas por motor:
  - PostgreSQL: cambia `BIGINT PRIMARY KEY` por `BIGSERIAL PRIMARY KEY` para auto-increment.
  - MySQL: usa `BIGINT AUTO_INCREMENT PRIMARY KEY`.
  - SQLite: usa `INTEGER PRIMARY KEY AUTOINCREMENT`.
  - Para payloads JSON en `registro_auditoria`, en Postgres usa `JSONB`, en MySQL `JSON`, en SQLite usa `TEXT`.

  Consideraciones:
  - Las reglas de cálculo (horas extras, porcentajes, impuestos) normalmente se implementan
    en la capa de aplicación o con funciones/procedimientos almacenados del motor. Aquí solo
    representamos los datos básicos y los resultados finales en `recibos` / `lineas_recibo`.
  - Para mantener historiales de tasas e impuestos, guarda `tasa_aplicada` / `tasa_contribucion_aplicada`
    en las líneas del recibo si necesitas reproducir cálculos históricos.
*/

