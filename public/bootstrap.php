<?php

$entityManager = require __DIR__ . '/../src/Infrastructure/Persistence/Doctrine/bootstrap.php';

use App\Http\Routing\RouteCollection;

$routes = new RouteCollection(__DIR__ . '/../config/routes.php');
$app = new App\Http\Routing\Router($routes);
