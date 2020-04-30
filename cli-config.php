<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;

require_once __DIR__.DIRECTORY_SEPARATOR.'bootstrap.php';

$entityManager = GetEntityManager();

return ConsoleRunner::createHelperSet($entityManager);
