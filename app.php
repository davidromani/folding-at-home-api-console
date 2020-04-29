#!/usr/bin/env php

<?php

require __DIR__.'/vendor/autoload.php';

use App\Command\FoldingCommand;
use App\Manager\FoldingTeamsApiManager;
use Symfony\Component\Console\Application;

$ftam = new FoldingTeamsApiManager('https://api.foldingathome.org/', 0);
$command = new FoldingCommand($ftam);

$application = new Application();
$application->add($command);
$application->setDefaultCommand($command->getName());

$application->run();
