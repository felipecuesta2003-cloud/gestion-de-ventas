# Gestión de ventas

Proyecto desarrollado en PHP con Laravel y MySQL.

## Requisitos

- PHP 8.2 o superior
- Composer
- MySQL

## Instalación

1. Crear una base de datos llamada `gestion_de_ventas`.

2. Copiar `.env.example` como `.env` y configurar la conexión a MySQL.

3. Ejecutar:

```bash
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan serve

4. Abrir en el navegador:

http://127.0.0.1:8000/sales