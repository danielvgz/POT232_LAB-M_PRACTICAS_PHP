import datetime
import re

FECHA_INICIO = datetime.date(2025, 9, 15)
TEMAS = [
    "¿Qué es PHP? Configuración y Hola Mundo.",
    "Concepto de servidor web.",
    "Variables y tipos de datos.",
    "Constantes y conversión de tipos.",
    "Operadores y estructuras de control.",
    "Bucles y control de flujo.",
    "Funciones y Formularios.",
    "Evaluación de lo que se vio el 22/09.",
    # Agrega más temas según tu calendario real
]
NOTAS = {
    (2, 2): "Hoy toca una evaluación de lo que se vio el 22/09."
}

def obtener_ultima_clase(fecha_actual):
    """Devuelve la semana, clase, número de clase y fecha de la última clase antes o igual a hoy."""
    if fecha_actual < FECHA_INICIO:
        return 0, 0, 0, FECHA_INICIO
    clase = 0
    semana = 1
    fecha = FECHA_INICIO
    ultima_clase_fecha = FECHA_INICIO
    while fecha <= fecha_actual:
        if fecha.weekday() in (1, 4):
            clase += 1
            ultima_clase_fecha = fecha
            if clase % 2 == 1 and clase > 1:
                semana += 1
        fecha += datetime.timedelta(days=1)
    clase_semana = 2 if ultima_clase_fecha.weekday() == 4 else 1
    return semana, clase_semana, clase, ultima_clase_fecha

def tema_y_nota(semana, clase_semana, clase):
    idx = clase - 1 if 0 <= clase - 1 < len(TEMAS) else -1
    tema = TEMAS[idx] if idx >= 0 else "Por definir"
    nota = NOTAS.get((semana, clase_semana), "")
    return tema, nota

def actualiza_estado_readme():
    hoy = datetime.date.today()
    # Encuentra la última clase (puede ser hoy o anterior)
    semana, clase_semana, clase, fecha_clase = obtener_ultima_clase(hoy)
    tema, nota = tema_y_nota(semana, clase_semana, clase)
    nueva_fila = f"| {semana}             | {hoy.strftime('%d/%m/%Y')}   | {tema}      | {nota} |"

    with open("README.md", encoding="utf-8") as f:
        contenido = f.read()

    patron = re.compile(
        r"(<!-- ESTADO-ACTUAL-INI -->)(.*?)(<!-- ESTADO-ACTUAL-FIN -->)",
        re.DOTALL
    )
    nueva_tabla = (
        "| Fecha de hoy  | "
        "| Semana actual |  Tema del día                 | Nota                                          |\n"
        "|---------------|-------------------------------|-----------------------------------------------|\n"
        f"{nueva_fila}\n"
    )
    nuevo_contenido = re.sub(patron, rf"\1\n{nueva_tabla}\3", contenido)

    with open("README.md", "w", encoding="utf-8") as f:
        f.write(nuevo_contenido)

    print(f"Actualizado a semana {semana}, clase {clase_semana}: {tema} (fecha: {hoy})")

if __name__ == "__main__":
    actualiza_estado_readme()
