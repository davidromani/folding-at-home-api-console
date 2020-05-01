<?php

namespace App\Command;

use App\Manager\FoldingTeamsApiManager;
use App\Manager\FoldingTeamsLocalStorageManager;
use App\Model\AbstractBase;
use App\Model\FoldingTeam as FoldingTeamModel;
use App\Model\FoldingTeamMemberAccount as FoldingTeamMemberAccountModel;
use DateTimeImmutable;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class FoldingGetTeamStatsCommand extends AbstractBaseCommand
{
    protected static $defaultName = 'folding:get:team:stats';
    private FoldingTeamsLocalStorageManager $ftlsm;
    private int                             $foldingTeamNumber;

    /**
     * Constructor.
     *
     * @param EntityManager|null $em
     */
    public function __construct(FoldingTeamsApiManager $fcm, EntityManager $em)
    {
        parent::__construct($fcm, $em);
        $this->ftlsm = new FoldingTeamsLocalStorageManager($em);
        $this->foldingTeamNumber = $fcm->getFoldingTeamNumber();
    }

    /**
     * Configure.
     */
    protected function configure()
    {
        $this
            ->setDescription('Get team stats')
            ->setHelp('Show a detailed view of current Folding@Home team stats.')
            ->addArgument('id', InputArgument::OPTIONAL, 'The Folding@Home team number.')
            ->addOption('persist', 'p', InputOption::VALUE_NONE, 'If set, result data will be persisted into a local storage database.')
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
        $io->title('Welcome to Folding@Home '.$this->getName().' command line tool');
        $io->section('Total current Folding@Home teams amount');
        $totalTeamsAmount = AbstractBase::getPrettyFormatValueInString($this->fcm->getCurrentTotalTeams());
        $io->text($totalTeamsAmount);
        /** @var FoldingTeamModel $team */
        $team = $this->fcm->getFoldingTeamById($input->getArgument('id'));
        $io->section('Team report');
        $io->table(
            ['#', 'Name', 'Members', 'Score', 'Work Units', 'Rank'],
            [
                [
                    $team->getId(),
                    $team->getName(),
                    count($team->getMemberAccounts()),
                    $team->getScoreString(),
                    $team->getWusString(),
                    $team->getRank() ? $team->getRankString().' of '.$totalTeamsAmount : 'unknown',
                ],
            ]
        );
        if (count($team->getMemberAccounts()) > 0) {
            $rows = [];
            $io->section('Team member accounts');
            /** @var FoldingTeamMemberAccountModel $teamMemberAccount */
            foreach ($team->getMemberAccounts() as $teamMemberAccount) {
                $rows[] = [
                    $teamMemberAccount->getId(),
                    $teamMemberAccount->getName(),
                    $teamMemberAccount->getScoreString(),
                    $teamMemberAccount->getWusString(),
                    $teamMemberAccount->getRank() ? $teamMemberAccount->getRankString().' of '.$totalTeamsAmount : 'unknown',
                ];
            }
            $io->table(
                ['#', 'Name', 'Score', 'Work Units', 'Rank'],
                $rows
            );
        }

        if ($input->getOption('persist')) {
            $isPersistedOrUpdated = $this->ftlsm->persistFoldingTeam($team);
            if (!$isPersistedOrUpdated) {
                $io->error('No data persisted in local storage');

                return AbstractBaseCommand::EXIT_COMMAND_FAILURE;
            }
        }
        $now = new DateTimeImmutable();
        $io->success('Reported data status at '.$now->format('d/m/Y H:i'));

        return AbstractBaseCommand::EXIT_COMMAND_SUCCESS;
    }
}
