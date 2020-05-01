<?php

namespace App\Command;

use App\Manager\FoldingTeamsApiManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractBaseCommand extends Command
{
    public const EXIT_COMMAND_SUCCESS = 0;
    public const EXIT_COMMAND_FAILURE = 1;

    protected ?FoldingTeamsApiManager $fcm;
    protected ?EntityManager          $em;

    /**
     * Constructor.
     */
    public function __construct(FoldingTeamsApiManager $fcm = null, ?EntityManager $em = null)
    {
        parent::__construct();
        $this->fcm = $fcm;
        $this->em = $em;
    }

    public function printCommandHeaderWelcomeAndGetConsoleStyle(InputInterface $input, OutputInterface $output)
    {
        $io = new ConsoleCustomStyle($input, $output);
        $io->title('Welcome to Folding@Home '.$this->getName().' command line tool');

        return $io;
    }
}
