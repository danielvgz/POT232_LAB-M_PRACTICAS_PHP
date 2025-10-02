import re
import datetime

README = "README.md"

def extraer_todas_las_clases(contenido):
    tablas = re.findall(
        r"\| *Semana *\| *Clase *\| *Fecha *\| *Contenido *\|([\s\S]+?)(?:\n\n|---|\Z)", contenido)
    clases = []
    for tabla in tablas:
        filas = re.findall(
            r"\| *(\d+) *\| *([\w\.]+) *\| *([\d\-]+) *\| *([^\|]+?) *\|", tabla[0])
        for semana, clase, fecha, tema in filas:
            try:
                fecha_obj = datetime.datetime.strptime(fecha.strip(), "%Y-%m-%d").date()
                clases.append({
                    "semana": int(semana),
                    "clase": clase.strip(),
                    "fecha": fecha_obj,
                    "tema": tema.strip()
                })
            except Exception:
                continue
    clases.sort(key=lambda x: (x["fecha"], x["clase"]))
    return clases

def actualizar_estado_actual(contenido, semana, clase, tema, fecha_clase, hoy):
    bloque = (
        f"**Fecha de hoy:** {hoy.strftime('%d/%m/%Y')}\n\n"
        "| Semana actual | Clase | Fecha |\n"
        "|:-------------:|:-------------------------:|:----------:|\n"
        f"| {semana:^13} | {tema:^25} | {fecha_clase.strftime('%d/%m/%Y'):^10} |\n"
    )
    patron = re.compile(
        r"(<!-- ESTADO-ACTUAL-INI -->)[\s\S]*?(<!-- ESTADO-ACTUAL-FIN -->)", re.DOTALL)
    nuevo_contenido = re.sub(patron, rf"\1\n{bloque}\2", contenido)
    return nuevo_contenido

def main():
    hoy = datetime.date.today()
    with open(README, encoding="utf-8") as f:
        contenido = f.read()
    clases = extraer_todas_las_clases(contenido)
    semana_actual = None
    clase_actual = None
    for clase in clases:
        if clase["fecha"] <= hoy:
            semana_actual = clase["semana"]
            clase_actual = clase
    if not clase_actual:
        print("No se encontró ninguna clase anterior a hoy.")
        return
    tema = clase_actual["tema"]
    fecha_clase = clase_actual["fecha"]
    clase_nombre = clase_actual["clase"]
    nuevo_contenido = actualizar_estado_actual(
        contenido, semana_actual, clase_nombre, tema, fecha_clase, hoy)
    if nuevo_contenido != contenido:
        with open(README, "w", encoding="utf-8") as f:
            f.write(nuevo_contenido)
        print("README actualizado correctamente.")
    else:
        print("No hubo cambios en el README.")

if __name__ == "__main__":
    main()
