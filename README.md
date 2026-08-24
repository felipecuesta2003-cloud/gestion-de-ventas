# Gestión de ventas

Proyecto desarrollado en PHP con Laravel y MySQL.

## Requisitos

- Docker Desktop

## Instalación

1. Clonar o descargar el proyecto.

2. Ejecutar:

```bash
docker compose up -d --build

```

3. Ejecutar las migraciones:

```bash


docker compose exec app php artisan migrate

```

4. Cargar los datos de prueba:


```bash


docker compose exec app php artisan db:seed

```
5. Abrir en el navegador:

http://localhost:8000/sales