import re
import datetime

README = "README.md"

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
        except Exception as e:
            print("Error en fila:", semana, clase, fecha, tema, "->", e)
    return clases

def clases_ultima_semana_pasada(clases, hoy):
    pasadas = [c for c in clases if c["fecha"] <= hoy]
    if pasadas:
        semana = pasadas[-1]["semana"]
        return [c for c in clases if c["semana"] == semana]
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

def actualizar_estado_fecha(contenido, hoy):
    bloque = f"**Fecha de hoy:** {hoy.strftime('%d/%m/%Y')}\n"
    patron = re.compile(r"(<!-- ESTADO-ACTUAL-INI -->)[\s\S]*?(<!-- ESTADO-ACTUAL-FIN -->)", re.DOTALL)
    return re.sub(patron, rf"\1\n{bloque}\2", contenido)

def actualizar_estado_tabla(contenido, bloque, estado):
    patron = re.compile(
        rf"(<!-- ESTADO-{estado}-INI -->)[\s\S]*?(<!-- ESTADO-{estado}-FIN -->)", re.DOTALL)
    if not re.search(patron, contenido):
        contenido = contenido.strip() + f"\n\n<!-- ESTADO-{estado}-INI -->\n<!-- ESTADO-{estado}-FIN -->\n"
    return re.sub(patron, rf"\1\n{bloque}\n\2", contenido)

def main():
    hoy = datetime.date.today()
    with open(README, encoding="utf-8") as f:
        contenido = f.read()

    # Estado de la fecha
    contenido = actualizar_estado_fecha(contenido, hoy)

    # Extrae clases
    clases = extraer_clases(contenido)

    # Estado 1: Última semana dictada
    pasadas = clases_ultima_semana_pasada(clases, hoy)
    bloque1 = "### Clase pasada\n\n" + tabla_markdown(pasadas)
    contenido = actualizar_estado_tabla(contenido, bloque1, "SEMANA-PASADA")

    # Estado 2: Próxima semana (si hay alguna futura)
    proximas, proxima_fecha = clases_proxima_semana(clases, hoy)
    if proximas:
        bloque2 = f"### Próxima semana de clase\n\n**Próxima fecha:** {proxima_fecha.strftime('%d/%m/%Y')}\n\n" + tabla_markdown(proximas)
    else:
        bloque2 = ""
    contenido = actualizar_estado_tabla(contenido, bloque2, "SEMANA-PROXIMA")

    with open(README, "w", encoding="utf-8") as f:
        f.write(contenido)
    print("README actualizado correctamente.")

if __name__ == "__main__":
    main()
