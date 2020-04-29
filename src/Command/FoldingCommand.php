<?php

namespace App\Command;

use App\Manager\FoldingApiManager;
use App\Model\FoldingTeamAccount;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FoldingCommand extends Command
{
    protected static $defaultName = 'app:test';
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
            ->setDescription('Testing command output.')
            ->setHelp('Say Hello World command.');
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
//        $output->writeLn('HTTP Response: '.$this->fcm->getTeamByIdNumberHttpContentResponse());
        $team = $this->fcm->getFoldingTeamByIdNumber();
        $output->writeLn($team);
        $output->writeLn('Total Folding@Home teams amount: '.$this->fcm->getCurrentTotalTeams());
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
