<?php

namespace App\Command;

use App\Manager\FoldingCrawlerManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FoldingCommand extends Command
{
    protected static $defaultName = 'app:test';
    private FoldingCrawlerManager $fcm;

    /**
     * Constructor
     *
     * @param FoldingCrawlerManager $fcm
     */
    public function __construct(FoldingCrawlerManager $fcm)
    {
        $this->fcm = $fcm;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Testing command output.')
            ->setHelp('Say Hello World command.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeLn($this->fcm->getCurrentTotalTeams());

        return 1;
    }
}
