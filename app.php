#!/usr/bin/env php

<?php

require_once __DIR__.DIRECTORY_SEPARATOR.'bootstrap.php';

use App\Command\FoldingGetTeamStatsCommand;
use App\Command\FoldingGetTeamStatsHistoryCommand;
use App\Command\ShowErrorCommand;
use App\Manager\FoldingTeamsLocalStorageManager;
use App\Manager\FoldingTeamsApiManager;
use App\Manager\FoldingUsersApiManager;
use Doctrine\ORM\ORMException;
use Symfony\Component\Console\Application;

const FOLDING_API_URL = 'https://api.foldingathome.org/';

$application = new Application();
try {



    // Managers
    $entityManager = GetEntityManager();
    $foldingTeamsLocalStorageManager = new FoldingTeamsLocalStorageManager($entityManager);
    $foldingTeamsApiManager = new FoldingTeamsApiManager(FOLDING_API_URL, 0);
    $foldingUsersApiManager = new FoldingUsersApiManager(FOLDING_API_URL);
    // Commands
    $foldingGetTeamStatsCommand = new FoldingGetTeamStatsCommand($foldingTeamsLocalStorageManager, $foldingTeamsApiManager, $foldingUsersApiManager, $entityManager, 0);
    $foldingGetTeamStatsHistoryCommand = new FoldingGetTeamStatsHistoryCommand($foldingTeamsLocalStorageManager, $foldingTeamsApiManager, $foldingUsersApiManager, $entityManager);
    // Application
    $application->add($foldingGetTeamStatsCommand);
    $application->add($foldingGetTeamStatsHistoryCommand);
    $application->setDefaultCommand($foldingGetTeamStatsCommand->getName());
    // Exceptions
} catch (ORMException $exception) {
    $errorCommand = new ShowErrorCommand($foldingTeamsLocalStorageManager, $foldingTeamsApiManager, $foldingUsersApiManager, $entityManager, 'Local storage initialization failure: '.$exception->getMessage());
    $application->add($errorCommand);
    $application->setDefaultCommand($errorCommand->getName());
} catch (InvalidArgumentException $exception) {
    $errorCommand = new ShowErrorCommand($foldingTeamsLocalStorageManager, $foldingTeamsApiManager, $foldingUsersApiManager, $entityManager, 'Invalid argument failure: '.$exception->getMessage());
    $application->add($errorCommand);
    $application->setDefaultCommand($errorCommand->getName());
} catch (Exception $exception) {
    $errorCommand = new ShowErrorCommand($foldingTeamsLocalStorageManager, $foldingTeamsApiManager, $foldingUsersApiManager, $entityManager, 'Unexpected failure: '.$exception->getMessage());
    $application->add($errorCommand);
    $application->setDefaultCommand($errorCommand->getName());
}

$application->run();
