import re
import datetime

README = "README.md"
ESTADO_MD = "clases-estado.md"

def extraer_clases(contenido):
    regex = r"\| *(\d+) *\| *([\w\.]+) *\| *([\d\-]+) *\|([^\n]*)\|"
    filas = re.findall(regex, contenido)
    clases = []
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
    return clases

def ultima_clase_dictada(clases, hoy):
    pasadas = [c for c in clases if c["fecha"] <= hoy]
    if pasadas:
        return [max(pasadas, key=lambda c: c["fecha"])]
    return []

def clases_proxima_semana(clases, hoy):
    futuras = [c for c in clases if c["fecha"] > hoy]
    if futuras:
        futuras = sorted(futuras, key=lambda c: c["fecha"])
        semana = futuras[0]["semana"]
        proxima_fecha = futuras[0]["fecha"]
        return [c for c in clases if c["semana"] == semana], proxima_fecha
    return [], None

def tabla_markdown(clases):
    if not clases:
        return "_Sin clases en este estado._"
    txt = "| Semana | Clase | Fecha | Contenido |\n"
    txt += "|:------:|:------:|:----------:|:-------------------------------|\n"
    for c in clases:
        txt += f"| {c['semana']} | {c['clase']} | {c['fecha'].strftime('%d/%m/%Y')} | {c['tema']} |\n"
    return txt

def main():
    hoy = datetime.date.today()
    with open(README, encoding="utf-8") as f:
        contenido = f.read()

    clases = extraer_clases(contenido)

    # Estado 1: Clase pasada (solo la última)
    ultima = ultima_clase_dictada(clases, hoy)
    bloque1 = "## Clase pasada\n\n" + tabla_markdown(ultima)

    # Estado 2: Próxima semana (si hay alguna futura)
    proximas, proxima_fecha = clases_proxima_semana(clases, hoy)
    if proximas:
        bloque2 = f"## Próxima semana de clase\n\n**Próxima fecha:** {proxima_fecha.strftime('%d/%m/%Y')}\n\n" + tabla_markdown(proximas)
    else:
        bloque2 = ""

    # Fecha de hoy
    fecha_hoy = f"**Fecha de hoy:** {hoy.strftime('%d/%m/%Y')}\n\n"
    with open(ESTADO_MD, "w", encoding="utf-8") as f:
        f.write(f"{fecha_hoy}{bloque1}\n\n{bloque2}\n")

if __name__ == "__main__":
    main()
