<?php

namespace App\Command;

use App\Manager\FoldingTeamsApiManager;
use App\Model\AbstractBase;
use App\Model\FoldingTeamMemberAccount;
use DateTimeImmutable;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FoldingCommand extends Command
{
    protected static $defaultName = 'folding:get:team:stats';

    private FoldingTeamsApiManager $fcm;
    private int $foldingTeamNumber;

    /**
     * Constructor
     *
     * @param FoldingTeamsApiManager $fcm
     */
    public function __construct(FoldingTeamsApiManager $fcm)
    {
        $this->fcm = $fcm;
        $this->foldingTeamNumber = $fcm->getFoldingTeamNumber();
        parent::__construct();
    }

    /**
     * Configure
     */
    protected function configure()
    {
        $this
            ->setDescription('Get team stats')
            ->setHelp('Show a detailed view of current Folding@Home team stats.')
            ->addArgument('id', InputArgument::OPTIONAL, 'The Folding@Home team number.')
        ;
    }

    /**
     * Execute
     *
     * @param InputInterface $input
     * @param OutputInterface $output
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
            /** @var FoldingTeamMemberAccount $teamMemberAccount */
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
        $now = new DateTimeImmutable();
        $io->success('Reported data status at '.$now->format('d/m/Y H:i'));

        return 1;
    }
}
