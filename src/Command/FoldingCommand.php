<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FoldingCommand extends Command
{
    protected static $defaultName = 'app:test';

    protected function configure()
    {
        $this
            ->setDescription('Testing command outputs.')
            ->setHelp('This command allows you to know how many cols & rows are in your current terminal window.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeLn('Hello World!');

        return 1;
    }
}
