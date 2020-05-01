<?php

namespace App\Command;

use App\Manager\FoldingTeamsLocalStorageManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FoldingGetTeamStatsHistoryCommand extends AbstractBaseCommand
{
    protected static $defaultName = 'folding:get:team:stats:history';
    private FoldingTeamsLocalStorageManager $ftlsm;

    /**
     * Constructor.
     *
     * @param EntityManager|null $em
     */
    public function __construct(EntityManager $em)
    {
        parent::__construct(null, $em);
        $this->ftlsm = new FoldingTeamsLocalStorageManager($em);
    }

    /**
     * Configure.
     */
    protected function configure()
    {
        $this
            ->setDescription('Get team stats history')
            ->setHelp('Show a history list of all team stats stored in the local database.')
        ;
    }

    /**
     * Execute.
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = $this->printCommandHeaderWelcomeAndGetConsoleStyle($input, $output);
        $teams = $this->ftlsm->getAllPersistedTeams();
        $io->success('Total teams recorded: '.count($teams));

        return AbstractBaseCommand::EXIT_COMMAND_SUCCESS;
    }
}
