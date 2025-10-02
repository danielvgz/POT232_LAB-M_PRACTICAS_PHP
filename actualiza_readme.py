import re
import datetime

README = "README.md"

def extraer_todas_las_clases(contenido):
    tablas = re.findall(
        r'\| *Semana *\| *Clase *\| *Fecha *\| *Contenido *\|([\s\S]+?)(\n\n|---|\Z)', contenido)
    clases = []
    for tabla in tablas:
        filas = re.findall(
            r'\| *(\d+) *\| *([\w\.]+) *\| *([\d\-]+) *\| *([^\|]+?) *\|', tabla[0])
        for semana, clase, fecha, tema in filas:
            try:
                fecha_obj = datetime.datetime.strptime(fecha, "%Y-%m-%d").date()
                clases.append((int(semana), clase, fecha_obj, tema.strip()))
            except Exception:
                continue
    clases.sort(key=lambda x: (x[2], x[1]))
    return clases

def determinar_estado_actual(clases, hoy):
    # Agrupa por semana
    semanas = {}
    for semana, clase, fecha, tema in clases:
        if semana not in semanas:
            semanas[semana] = []
        semanas[semana].append((clase, fecha, tema))

    semana_actual = None
    clase_actual = None
    fecha_actual = None
    tema_actual = None

    # Busca la semana más alta cuya primera clase ya haya ocurrido
    for semana in sorted(semanas.keys()):
        fechas_semana = [f for _, f, _ in semanas[semana]]
        if min(fechas_semana) <= hoy:
            semana_actual = semana

    if semana_actual is not None:
        # Si hoy es igual o mayor que la primera clase de esa semana, mostrar la última clase de esa semana <= hoy
        posibles = [(clase, fecha, tema) for clase, fecha, tema in semanas[semana_actual] if fecha <= hoy]
        if posibles:
            clase_actual, fecha_actual, tema_actual = max(posibles, key=lambda x: x[1])
        else:
            # Si no hay clases pasadas esta semana, toma la primera futura de esa semana
            clase_actual, fecha_actual, tema_actual = min(semanas[semana_actual], key=lambda x: x[1])
        return semana_actual, tema_actual, fecha_actual
    return None, None, None

def actualizar_estado_actual(contenido, semana, tema, fecha_clase, hoy):
    tabla = (
        f"**Fecha de hoy:** {hoy.strftime('%d/%m/%Y')}\n\n"
        "| Semana actual | Última clase                          | Fecha última clase |\n"
        "|:-------------:|:-------------------------------------:|:-----------------:|\n"
        f"| {semana:^13} | {tema:^37} | {fecha_clase.strftime('%d/%m/%Y'):^17} |\n"
    )
    patron = re.compile(
        r"(<!-- ESTADO-ACTUAL-INI -->)(.*?)(<!-- ESTADO-ACTUAL-FIN -->)", re.DOTALL)
    nuevo_contenido = re.sub(patron, rf"\1\n{tabla}\3", contenido)
    return nuevo_contenido

def main():
    hoy = datetime.date.today()
    with open(README, encoding="utf-8") as f:
        contenido = f.read()
    clases = extraer_todas_las_clases(contenido)
    semana, tema, fecha_clase = determinar_estado_actual(clases, hoy)
    if semana is None:
        print("No se encontró ninguna clase anterior a hoy.")
        return
    nuevo_contenido = actualizar_estado_actual(contenido, semana, tema, fecha_clase, hoy)
    # Si el contenido es diferente, escribe el archivo (esto fuerza el cambio siempre que la fecha cambie)
    if nuevo_contenido != contenido:
        with open(README, "w", encoding="utf-8") as f:
            f.write(nuevo_contenido)
        print("README actualizado correctamente.")
    else:
        print("No hubo cambios en el README.")

if __name__ == "__main__":
    main()
