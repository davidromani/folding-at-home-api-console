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
            ->setDescription('Testing command output.')
            ->setHelp('Say Hello World command.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeLn('Hello World!');

        return 1;
    }
}
