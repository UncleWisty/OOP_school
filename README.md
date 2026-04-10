OOP_school
=========

App para organizar una escuela con PHP


Contents
------------
API REST básica que usa Doctrine para guardar datos (las vistas estan deprecated ahora mismo)

Setup
----------------------
1. Instala dependencias:

```bash
composer install
```

2. Copia el `.env`:

```bash
cp .env.example .env
# edita .env
```

3. Crea o actualiza la base de datos:

```bash
php bin/doctrine orm:schema-tool:update --force
# o para crearlo de cero:
php bin/doctrine orm:schema-tool:create
```

Running
-----------------------
Puedes usar el servidor de PHP desde la raiz del proyecto:

```bash
php -S localhost:8000 -t public
```

La API queda en `/api/*`. Mira `config/routes.php` para ver las rutas.

Tests
-----
Hay tests en `tests/`

```bash
vendor/bin/phpunit
```
