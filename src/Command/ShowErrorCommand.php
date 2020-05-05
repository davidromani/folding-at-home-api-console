<?php

namespace App\Command;

use App\Manager\FoldingTeamsApiManager;
use App\Manager\FoldingTeamsLocalStorageManager;
use App\Manager\FoldingUsersApiManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ShowErrorCommand extends AbstractBaseCommand
{
    protected static $defaultName = 'folding:show:error';
    private string $errorMessage;

    /**
     * Methods.
     */

    /**
     * Constructor.
     */
    public function __construct(FoldingTeamsLocalStorageManager $ftlsm, FoldingTeamsApiManager $ftam, FoldingUsersApiManager $fuam, EntityManager $em, string $errorMessage)
    {
        parent::__construct($ftlsm, $ftam, $fuam, $em);
        $this->errorMessage = $errorMessage;
    }

    /**
     * Configure.
     */
    protected function configure()
    {
        $this
            ->setDescription('Show error message')
            ->setHelp('Show a detailed error message console output.')
        ;
    }

    /**
     * Execute.
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new ConsoleCustomStyle($input, $output);
        $io->error($this->errorMessage);

        return AbstractBaseCommand::EXIT_COMMAND_FAILURE;
    }
}
