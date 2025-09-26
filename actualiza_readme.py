import datetime
import re

# Configuración inicial
FECHA_INICIO = datetime.date(2025, 9, 15)  # Primer martes de clases
TEMAS = [
    "¿Qué es PHP? Configuración y Hola Mundo.",
    "Concepto de servidor web.",
    "Variables y tipos de datos.",
    "Constantes y conversión de tipos.",
    "Operadores y estructuras de control.",
    "Bucles y control de flujo.",
    "Funciones y Formularios.",
    "Evaluación de lo que se vio el 22/09.",
    # Agrega más temas según avance el curso
]

NOTAS = {
    # (semana, clase_semana): nota
    (2, 2): "Hoy toca una evaluación de lo que se vio el 22/09."
    # Puedes agregar más notas si lo necesitas
}

def obtener_semana_y_clase(fecha_actual):
    """Calcula la semana y el número de clase según la fecha."""
    if fecha_actual < FECHA_INICIO:
        return 0, 0, 0
    clase = 0
    semana = 1
    fecha = FECHA_INICIO
    while fecha <= fecha_actual:
        if fecha.weekday() in (1, 4):  # martes o viernes
            clase += 1
            if clase % 2 == 1 and clase > 1:
                semana += 1
        fecha += datetime.timedelta(days=1)
    clase_semana = 2 if fecha_actual.weekday() == 4 else 1
    return semana, clase_semana, clase

def tema_y_nota(semana, clase_semana, clase):
    idx = clase - 1 if 0 <= clase - 1 < len(TEMAS) else -1
    tema = TEMAS[idx] if idx >= 0 else "Por definir"
    nota = NOTAS.get((semana, clase_semana), "")
    return tema, nota

def actualiza_estado_readme():
    hoy = datetime.date.today()
    semana, clase_semana, clase = obtener_semana_y_clase(hoy)
    tema, nota = tema_y_nota(semana, clase_semana, clase)
    nueva_fila = f"| {{semana}}             | {{hoy.strftime('%d/%m/%Y')}}   | {{tema}}      | {{nota}} |"

    with open("README.md", encoding="utf-8") as f:
        contenido = f.read()

    patron = re.compile(
        r"(<!-- ESTADO-ACTUAL-INI -->)(.*?)(<!-- ESTADO-ACTUAL-FIN -->)",
        re.DOTALL
    )
    nueva_tabla = (
        "| Semana actual | Fecha de hoy | Tema del día                 | Nota                                          |\n"
        "|---------------|--------------|------------------------------|-----------------------------------------------|\n"
        f"{{nueva_fila}}\n"
    )
    nuevo_contenido = re.sub(patron, rf"\1\n{{nueva_tabla}}\3", contenido)

    with open("README.md", "w", encoding="utf-8") as f:
        f.write(nuevo_contenido)

    print(f"Actualizado a semana {{semana}}, clase {{clase_semana}}: {{tema}}")

if __name__ == "__main__":
    actualiza_estado_readme()