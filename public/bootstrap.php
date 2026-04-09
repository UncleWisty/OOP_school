<?php

ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');

$entityManager = require __DIR__ . '/../src/Infrastructure/Persistence/Doctrine/bootstrap.php';

use App\Http\Routing\RouteCollection;

$routes = new RouteCollection(__DIR__ . '/../config/routes.php');
$app = new App\Http\Routing\Router($routes);
