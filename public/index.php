<?php

require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

require __DIR__ . '/bootstrap.php';

use App\Http\Request;

$req = new Request();

$app->dispatch($req, $entityManager);
