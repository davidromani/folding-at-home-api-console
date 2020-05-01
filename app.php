#!/usr/bin/env php

<?php

require_once __DIR__.DIRECTORY_SEPARATOR.'bootstrap.php';

use App\Command\FoldingGetTeamStatsCommand;
use App\Command\FoldingGetTeamStatsHistoryCommand;
use App\Command\ShowErrorCommand;
use App\Manager\FoldingTeamsApiManager;
use Doctrine\ORM\ORMException;
use Symfony\Component\Console\Application;

$application = new Application();
try {
    // Services
    $entityManager = GetEntityManager();
    $foldingTeamsApiManager = new FoldingTeamsApiManager('https://api.foldingathome.org/', 0);
    $foldingGetTeamStatsCommand = new FoldingGetTeamStatsCommand($foldingTeamsApiManager, $entityManager);
    $foldingGetTeamStatsHistoryCommand = new FoldingGetTeamStatsHistoryCommand($entityManager);
    $application->add($foldingGetTeamStatsCommand);
    $application->add($foldingGetTeamStatsHistoryCommand);
    $application->setDefaultCommand($foldingGetTeamStatsCommand->getName());
} catch (ORMException $exception) {
    $errorCommand = new ShowErrorCommand('Local storage initialization failure');
    $application->add($errorCommand);
    $application->setDefaultCommand($errorCommand->getName());
}

$application->run();
