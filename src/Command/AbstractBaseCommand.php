<?php

namespace App\Command;

use App\Manager\FoldingTeamsApiManager;
use App\Manager\FoldingTeamsLocalStorageManager;
use App\Manager\FoldingUsersApiManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractBaseCommand extends Command
{
    public const EXIT_COMMAND_SUCCESS = 0;
    public const EXIT_COMMAND_FAILURE = 1;

    protected FoldingTeamsLocalStorageManager $ftlsm;
    protected FoldingTeamsApiManager          $ftam;
    protected FoldingUsersApiManager          $fuam;
    protected EntityManager                   $em;

    /**
     * Methods.
     */

    /**
     * Constructor.
     */
    public function __construct(FoldingTeamsLocalStorageManager $ftlsm, FoldingTeamsApiManager $ftam, FoldingUsersApiManager $fuam, EntityManager $em)
    {
        parent::__construct();
        $this->ftlsm = $ftlsm;
        $this->ftam = $ftam;
        $this->fuam = $fuam;
        $this->em = $em;
    }

    public function printCommandHeaderWelcomeAndGetConsoleStyle(InputInterface $input, OutputInterface $output)
    {
        $io = new ConsoleCustomStyle($input, $output);
        $io->title('Welcome to Folding@Home '.$this->getName().' command line tool');

        return $io;
    }
}
