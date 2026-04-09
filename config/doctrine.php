<?php

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\DBAL;

return function(): EntityManager {
    $paths = [__DIR__ . '/../src/Domain'];
    $isDevMode = true;
    $config = ORMSetup::createAttributeMetadataConfig(
        $paths,
        $isDevMode
    );

    $config->enableNativeLazyObjects(true);
    $dbParams = [
        'driver' => $_ENV['DB_DRIVER'],
        'host' => $_ENV['DB_HOST'],
        'port' => $_ENV['DB_PORT'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
        'dbname' => $_ENV['DB_NAME'],
    ];
    $connection = DriverManager::getConnection($dbParams, $config);

    return new EntityManager($connection, $config);
};
