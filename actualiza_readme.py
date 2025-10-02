import re
import datetime

README = "README.md"

def actualizar_fecha(contenido, hoy):
    bloque = f"**Fecha de hoy:** {hoy.strftime('%d/%m/%Y')}\n"
    patron = re.compile(r"(<!-- ESTADO-ACTUAL-INI -->)[\s\S]*?(<!-- ESTADO-ACTUAL-FIN -->)", re.DOTALL)
    nuevo_contenido = re.sub(patron, rf"\1\n{bloque}\2", contenido)
    return nuevo_contenido


def extraer_clases(contenido):
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
                    "semana": semana,
                    "clase": clase,
                    "fecha": fecha_obj,
                    "tema": tema.strip()
                })
            except Exception:
                continue
    return clases

def actualizar_estado_cronograma_simple(contenido, clases, hoy):
    # Solo texto plano, una línea por clase
    filas = [
        f"Semana {c['semana']} | Clase {c['clase']} | {c['fecha']} | {c['tema']}"
        for c in clases if c["fecha"] <= hoy
    ]
    if not filas:
        bloque = "Sin clases dictadas aún."
    else:
        bloque = "\n".join(filas)
    patron = re.compile(r"(<!-- ESTADO-CRONOGRAMA-INI -->)[\s\S]*?(<!-- ESTADO-CRONOGRAMA-FIN -->)", re.DOTALL)
    if not re.search(patron, contenido):
        contenido = contenido.strip() + "\n\n<!-- ESTADO-CRONOGRAMA-INI -->\n<!-- ESTADO-CRONOGRAMA-FIN -->\n"
    nuevo_contenido = re.sub(patron, rf"\1\n{bloque}\n\2", contenido)
    return nuevo_contenido

def main():
    hoy = datetime.date.today()
    with open(README, encoding="utf-8") as f:
        contenido = f.read()
    # Actualiza fecha
    nuevo_contenido = actualizar_fecha(contenido, hoy)
    # Extrae clases y actualiza estado cronograma
    clases = extraer_clases(nuevo_contenido)
   nuevo_contenido = actualizar_estado_cronograma_simple(contenido, clases, hoy)
    if nuevo_contenido != contenido:
        with open(README, "w", encoding="utf-8") as f:
            f.write(nuevo_contenido)
        print("README actualizado correctamente.")
    else:
        print("No hubo cambios en el README.")
if __name__ == "__main__":
    main()
