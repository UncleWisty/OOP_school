#!/usr/bin/env php
<?php


require_once __DIR__ . '/../vendor/autoload.php';

if (class_exists(\Dotenv\Dotenv::class)) {
	$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
	$dotenv->load();
}

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;

$entityManager = require __DIR__ . '/../src/Infrastructure/Persistence/Doctrine/bootstrap.php';

ConsoleRunner::run(new SingleManagerProvider($entityManager));
