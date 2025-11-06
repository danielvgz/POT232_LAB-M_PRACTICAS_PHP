# Laravel + Vue.js Application

Este es un proyecto Laravel 11 integrado con Vue.js 3 utilizando Laravel Breeze e Inertia.js.

## Requisitos

- PHP 8.2 o superior
- Composer
- Node.js 20.x o superior
- NPM 10.x o superior
- SQLite (o MySQL/PostgreSQL)

## Instalación

1. Instalar dependencias de PHP:
```bash
composer install
```

2. Instalar dependencias de Node.js:
```bash
npm install
```

3. Configurar el archivo de entorno:
```bash
cp .env.example .env
php artisan key:generate
```

4. Crear la base de datos (SQLite):
```bash
touch database/database.sqlite
```

5. Ejecutar las migraciones:
```bash
php artisan migrate
```

## Desarrollo

Para iniciar el servidor de desarrollo:

```bash
# Terminal 1: Servidor Laravel
php artisan serve

# Terminal 2: Vite dev server (para Vue.js)
npm run dev
```

Luego abre tu navegador en: `http://localhost:8000`

## Construcción para Producción

```bash
npm run build
```

## Stack Tecnológico

- **Backend**: Laravel 11
- **Frontend**: Vue.js 3 + Inertia.js
- **CSS**: Tailwind CSS
- **Build Tool**: Vite
- **Autenticación**: Laravel Breeze


## Estructura del Proyecto

```
laravel-vue-app/
├── app/              # Código PHP de la aplicación
├── resources/
│   ├── js/          # Componentes Vue.js
│   │   ├── Components/  # Componentes reutilizables
│   │   ├── Layouts/     # Layouts de la aplicación
│   │   └── Pages/       # Páginas de la aplicación
│   └── views/       # Vistas Blade (Inertia root)
├── routes/          # Definición de rutas
├── database/        # Migraciones y seeders
└── public/          # Assets públicos
```

## Recursos de Aprendizaje

- [Documentación de Laravel](https://laravel.com/docs)
- [Documentación de Vue.js](https://vuejs.org/guide/introduction.html)
- [Documentación de Inertia.js](https://inertiajs.com/)
- [Laravel Breeze](https://laravel.com/docs/starter-kits#laravel-breeze)

## Licencia

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
