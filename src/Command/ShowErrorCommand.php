<?php

namespace App\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ShowErrorCommand extends AbstractBaseCommand
{
    protected static $defaultName = 'folding:show:error';
    private string   $errorMessage;

    /**
     * Methods
     */

    /**
     * Constructor
     *
     * @param string $errorMessage
     */
    public function __construct(string $errorMessage)
    {
        parent::__construct();
        $this->errorMessage = $errorMessage;
    }

    /**
     * Configure
     */
    protected function configure()
    {
        $this
            ->setDescription('Show error message')
            ->setHelp('Show a detailed error message console output.')
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
        $io->error($this->errorMessage);

        return AbstractBaseCommand::EXIT_COMMAND_FAILURE;
    }
}
