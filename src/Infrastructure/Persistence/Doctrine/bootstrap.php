<?php

$entityManagerFactory = require __DIR__ . '/../../../../config/doctrine.php';

$entityManager = $entityManagerFactory();

return $entityManager;
