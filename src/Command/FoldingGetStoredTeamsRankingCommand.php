<?php

namespace App\Command;

use App\Entity\FoldingTeam;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class FoldingGetStoredTeamsRankingCommand extends AbstractBaseCommand
{
    protected static $defaultName = 'folding:get:stored:teams:ranking';

    /**
     * Methods.
     */

    /**
     * Configure.
     */
    protected function configure()
    {
        $this
            ->setDescription('Get local database teams total rankings')
            ->setHelp('Get total team rankings list stored in local database.')
            ->addOption(
                'sorted-by',
                's',
                InputOption::VALUE_REQUIRED,
                'Sort by team "name", "score", "WU" or "rank" options.',
                'name'
            )
            ->addOption(
                'order-by',
                'o',
                InputOption::VALUE_REQUIRED,
                'Order list by "asc"ending or "desc"ending option.',
                'asc'
            )
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
        $orderBy = 'ASC';
        if ($input->getOption('order-by') === 'desc') {
            $orderBy = 'DESC';
        }
        if ($input->getOption('sorted-by') === 'score') {
            $teams = $this->ftlsm->getAllPersistedTeamsSortedByScore($orderBy);
        } elseif ($input->getOption('sorted-by') === 'WU') {
            $teams = $this->ftlsm->getAllPersistedTeamsSortedByWu($orderBy);
        } elseif ($input->getOption('sorted-by') === 'rank') {
            $teams = $this->ftlsm->getAllPersistedTeamsSortedByRank($orderBy);
        } else {
            $teams = $this->ftlsm->getAllPersistedTeamsSortedByName($orderBy);
        }
        if (count($teams) > 0) {
            $rows = [];
            $io->newLine();
            /** @var FoldingTeam $team */
            foreach ($teams as $team) {
                $rows[] = [
                    $team->getFoldingId(),
                    $team->getName(),
                    $team->getFounder(),
                    $team->getUrl(),
                    $team->getScoreString(),
                    $team->getWusString(),
                    $team->getRank() ? $team->getRankString() : 'unknown',
                ];
            }
            $io->table(
                ['#', 'Name', 'Founder', 'URL', 'Score', 'Work Units', 'Rank'],
                $rows
            );
            $io->success('Total teams recorded: '.count($teams));
        } else {
            $io->warning('No teams stored in local database. Try to execute "folding:get:team:stats <id> --persist" first.');
        }

        return AbstractBaseCommand::EXIT_COMMAND_SUCCESS;
    }
}
