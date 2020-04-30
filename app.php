#!/usr/bin/env php

<?php

require __DIR__.'/vendor/autoload.php';

use App\Command\FoldingCommand;
use App\Command\ShowErrorCommand;
use App\Manager\FoldingTeamsApiManager;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Symfony\Component\Console\Application;

// ORM
$isDevMode = false;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;
$config = Setup::createAnnotationMetadataConfiguration(
    array(__DIR__."/src"),
    $isDevMode,
    $proxyDir,
    $cache,
    $useSimpleAnnotationReader
);
$connection = array(
    'driver' => 'pdo_sqlite',
    'path' => __DIR__.'var'.DIRECTORY_SEPARATOR.'storage.sqlite',
);

// Services
$application = new Application();
try {
    $em = EntityManager::create($connection, $config);
    $ftam = new FoldingTeamsApiManager('https://api.foldingathome.org/', 0);
    $command = new FoldingCommand($ftam, $em);
    $application->add($command);
    $application->setDefaultCommand($command->getName());
} catch (ORMException $exception) {
    $command = new ShowErrorCommand('Local storage initialization failure');
    $application->add($command);
    $application->setDefaultCommand($command->getName());
}

$application->run();

