import re
import datetime

README = "README.md"

def extraer_todas_las_clases(contenido):
    """
    Extrae todas las clases del cronograma de todas las tablas del README.
    Devuelve una lista de tuplas: (semana, clase, fecha, tema)
    """
    # Busca todas las tablas de cronograma
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
    # Ordenar por fecha
    clases.sort(key=lambda x: x[2])
    return clases

def encontrar_clase_actual(clases, hoy):
    """
    Retorna la info de la clase más reciente cuya fecha sea <= hoy.
    """
    clases_pasadas = [c for c in clases if c[2] <= hoy]
    if not clases_pasadas:
        return None
    # Tomamos la clase con la fecha más reciente <= hoy
    return max(clases_pasadas, key=lambda c: c[2])

def actualizar_estado_actual(contenido, semana, tema, fecha_clase, hoy):
    """
    Actualiza la sección <!-- ESTADO-ACTUAL-INI --> ... <!-- ESTADO-ACTUAL-FIN -->
    en el README.
    """
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
    clase_actual = encontrar_clase_actual(clases, hoy)
    if not clase_actual:
        print("No se encontró ninguna clase para la fecha de hoy o antes.")
        return

    semana, _, fecha_clase, tema = clase_actual
    nuevo_contenido = actualizar_estado_actual(contenido, semana, tema, fecha_clase, hoy)

    with open(README, "w", encoding="utf-8") as f:
        f.write(nuevo_contenido)
    print("README actualizado correctamente.")

if __name__ == "__main__":
    main()
