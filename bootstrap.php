<?php

require_once __DIR__.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

function GetEntityManager()
{
    // ORM
    $isDevMode = false;
    $proxyDir = null;
    $cache = null;
    $useSimpleAnnotationReader = false;
    $config = Setup::createAnnotationMetadataConfiguration(
        array(__DIR__.DIRECTORY_SEPARATOR.'src'),
        $isDevMode,
        $proxyDir,
        $cache,
        $useSimpleAnnotationReader
    );
    $connection = array(
        'driver' => 'pdo_sqlite',
        'path' => __DIR__.DIRECTORY_SEPARATOR.'var'.DIRECTORY_SEPARATOR.'storage.sqlite',
    );

    return EntityManager::create($connection, $config);
}
