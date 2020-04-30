#!/usr/bin/env php

<?php

require_once __DIR__.DIRECTORY_SEPARATOR.'bootstrap.php';

use App\Command\FoldingCommand;
use App\Command\ShowErrorCommand;
use App\Manager\FoldingTeamsApiManager;
use Doctrine\ORM\ORMException;
use Symfony\Component\Console\Application;

// Services
$application = new Application();
try {
    $em = GetEntityManager();
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
