<?php

namespace App\Command;

use App\Manager\FoldingApiManager;
use App\Model\FoldingTeamAccount;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FoldingCommand extends Command
{
    protected static $defaultName = 'app:get:team:stats';
    private FoldingApiManager $fcm;

    /**
     * Constructor
     *
     * @param FoldingApiManager $fcm
     */
    public function __construct(FoldingApiManager $fcm)
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
            ->setHelp('Show a detailed view of current Folding@Home team stats.');
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
        $team = $this->fcm->getFoldingTeamById();
        $output->writeLn($team);
        if (count($team->getAccounts()) > 0) {
            $output->writeln('Accounts:');
            /** @var FoldingTeamAccount $account */
            foreach ($team->getAccounts() as $account) {
                $output->writeLn($account);
            }
        }

        return 1;
    }
}
