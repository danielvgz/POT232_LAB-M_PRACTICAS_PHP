import re
import datetime

README = "README.md"

def extraer_todas_las_clases(contenido):
    # Busca todas las tablas de cronograma
    tablas = re.findall(
        r"\| *Semana *\| *Clase *\| *Fecha *\| *Contenido *\|([\s\S]+?)(\n\n|---|\Z)", contenido)
    clases = []
    for tabla in tablas:
        filas = re.findall(
            r"\| *(\d+) *\| *([\w\.]+) *\| *([\d\-]+) *\| *([^\|]+?) *\|", tabla[0])
        for semana, clase, fecha, tema in filas:
            try:
                fecha_obj = datetime.datetime.strptime(fecha, "%Y-%m-%d").date()
                clases.append({
                    "semana": int(semana),
                    "clase": clase,
                    "fecha": fecha_obj,
                    "tema": tema.strip()
                })
            except Exception:
                continue
    clases.sort(key=lambda x: (x["fecha"], x["clase"]))
    return clases

def actualizar_estado_actual(contenido, semana, tipo, tema, fecha_clase, hoy):
    tabla = (
        f"**Fecha de hoy:** {hoy.strftime('%d/%m/%Y')}\n\n"
        f"| Semana actual | {tipo} | Fecha |\n"
        f"|:-------------:|:--------------------------------------------------:|:----------:|\n"
        f"| {semana:^13} | {tema:^50} | {fecha_clase.strftime('%d/%m/%Y'):^10} |\n"
    )
    patron = re.compile(
        r"(<!-- ESTADO-ACTUAL-INI -->)[\s\S]*?(<!-- ESTADO-ACTUAL-FIN -->)", re.DOTALL)
    nuevo_contenido = re.sub(patron, rf"\1\n{tabla}\2", contenido)
    return nuevo_contenido

def main():
    hoy = datetime.date.today()
    with open(README, encoding="utf-8") as f:
        contenido = f.read()
    clases = extraer_todas_las_clases(contenido)
    # Encuentra la semana actual
    semana_actual = None
    clase_actual = None
    for clase in clases:
        if clase["fecha"] <= hoy:
            semana_actual = clase["semana"]
            clase_actual = clase
    if not clase_actual:
        print("No se encontró ninguna clase anterior a hoy.")
        return
    # Determina si es Clase o Módulo (por el nombre, puedes ajustar)
    tipo = "Clase" if "clase" in clase_actual["clase"].lower() or re.match(r'\d+\.\d+', clase_actual["clase"]) else "Módulo"
    tema = clase_actual["tema"]
    fecha_clase = clase_actual["fecha"]
    nuevo_contenido = actualizar_estado_actual(
        contenido, semana_actual, tipo, tema, fecha_clase, hoy)
    with open(README, "w", encoding="utf-8") as f:
        f.write(nuevo_contenido)
    print("README actualizado correctamente.")

if __name__ == "__main__":
    main()
