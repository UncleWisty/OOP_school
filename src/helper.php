<?php

/**
 * Helper functions for the API
 */

/**
 * Generate a v4 UUID (Universally Unique Identifier)
 */
function generateUUID(): string
{
    return sprintf(
        '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
}

/**
 * Convert entity object to array
 */
function entityToArray($entity): array
{
    $reflection = new ReflectionClass($entity);
    $data = [];

    foreach ($reflection->getProperties() as $property) {
        $property->setAccessible(true);
        $value = $property->getValue($entity);
        
        // Try to call getter method if it exists
        $methodName = 'get' . ucfirst($property->getName());
        if (method_exists($entity, $methodName)) {
            $value = $entity->$methodName();
        }
        
        $data[$property->getName()] = $value;
    }

    return $data;
}
