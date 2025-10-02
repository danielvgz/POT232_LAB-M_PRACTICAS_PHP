import re
import datetime

README = "README.md"

def actualizar_fecha(contenido, hoy):
    bloque = f"**Fecha de hoy:** {{hoy.strftime('%d/%m/%Y')}}\n"
    patron = re.compile(r"(<!-- ESTADO-ACTUAL-INI -->)[\s\S]*?(<!-- ESTADO-ACTUAL-FIN -->)", re.DOTALL)
    nuevo_contenido = re.sub(patron, rf"\1\n{{bloque}}\2", contenido)
    return nuevo_contenido

def main():
    hoy = datetime.date.today()
    with open(README, encoding="utf-8") as f:
        contenido = f.read()
    nuevo_contenido = actualizar_fecha(contenido, hoy)
    if nuevo_contenido != contenido:
        with open(README, "w", encoding="utf-8") as f:
            f.write(nuevo_contenido)
        print("README actualizado correctamente.")
    else:
        print("No hubo cambios en el README.")

if __name__ == "__main__":
    main()