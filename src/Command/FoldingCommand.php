<?php

namespace App\Command;

use App\Manager\FoldingTeamsApiManager;
use App\Model\FoldingTeamMemberAccount;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FoldingCommand extends Command
{
    protected static $defaultName = 'app:get:team:stats';
    private FoldingTeamsApiManager $fcm;

    /**
     * Constructor
     *
     * @param FoldingTeamsApiManager $fcm
     */
    public function __construct(FoldingTeamsApiManager $fcm)
    {
        $this->fcm = $fcm;
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
        $output->writeLn('Total current Folding@Home teams amount: '.$this->fcm->getCurrentTotalTeams());
        $team = $this->fcm->getFoldingTeamById($input->getArgument('id'));
        $output->writeLn($team);
        if (count($team->getMemberAccounts()) > 0) {
            $output->writeln('Team member accounts:');
            /** @var FoldingTeamMemberAccount $teamMemberAccount */
            foreach ($team->getMemberAccounts() as $teamMemberAccount) {
                $output->writeLn($teamMemberAccount);
            }
        }

        return 1;
    }
}
