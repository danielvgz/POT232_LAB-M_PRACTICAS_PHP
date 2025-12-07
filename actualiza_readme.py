import re
from datetime import datetime
import requests
from bs4 import BeautifulSoup

README_PATH = "README.md"

def get_today():
    """Devuelve la fecha de hoy en formato dd/mm/yyyy."""
    return datetime.now().strftime("%d/%m/%Y")

def update_estado_actual(contents, today):
    """Actualiza la fecha de hoy en el bloque ESTADO-ACTUAL."""
    pattern = re.compile(r'(<!-- ESTADO-ACTUAL-INI -->)(.*?)(<!-- ESTADO-ACTUAL-FIN -->)', re.DOTALL)
    new_block = f'<!-- ESTADO-ACTUAL-INI -->\n**Fecha de hoy:** {today}\n<!-- ESTADO-ACTUAL-FIN -->'
    return re.sub(pattern, new_block, contents)

def scrape_christmas_quote():
    """Obtiene una frase navideña de un sitio de frases célebres."""
    url = "https://www.proverbia.net/citastema.asp?tematica=121"  # Temática de Navidad
    try:
        resp = requests.get(url, timeout=10)
        resp.raise_for_status()
        soup = BeautifulSoup(resp.text, "html.parser")
        frases = [f.text.strip() for f in soup.find_all('span', class_='frase')]
        autores = [a.text.strip() for a in soup.find_all('span', class_='autor')]
        if frases and autores:
            import random
            n = random.randint(0, min(len(frases), len(autores))-1)
            return f'"{frases[n]}"\n> *{autores[n]}*'
    except Exception as e:
        print(f"Error obteniendo frase navideña: {e}")
    # Frase por defecto si hay error
    return '"La Navidad no es un momento ni una estación, sino un estado de la mente." \n> *Calvin Coolidge*'

def update_frase_del_dia(contents, frase):
    """Actualiza o agrega el bloque de frases del día."""
    phrase_pattern = re.compile(r'(\*\*Frases Del día:\*\*\n)(.*?)(\n\n|$)', re.DOTALL)
    if '**Frases Del día:**' in contents:
        # Reemplaza solo el mensaje, mantiene el encabezado
        return re.sub(phrase_pattern, f'**Frases Del día:**\n{frase}\n\n', contents)
    else:
        # Inserta tras ESTADO-ACTUAL-FIN
        insert_point = contents.find('<!-- ESTADO-ACTUAL-FIN -->') + len('<!-- ESTADO-ACTUAL-FIN -->')
        return contents[:insert_point] + f"\n\n**Frases Del día:**\n{frase}\n\n" + contents[insert_point:]

def main():
    today = get_today()
    frase = scrape_christmas_quote()
    with open(README_PATH, encoding="utf-8") as f:
        contents = f.read()
    new_contents = update_estado_actual(contents, today)
    new_contents = update_frase_del_dia(new_contents, frase)
    with open(README_PATH, "w", encoding="utf-8") as f:
        f.write(new_contents)
    print(f"Actualizado README.md con fecha {today} y frase del día.")

if __name__ == "__main__":
    main()
