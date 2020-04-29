<?php

namespace App\Command;

use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\StyleInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ConsoleCustomStyle extends SymfonyStyle implements StyleInterface
{
    private BufferedOutput $bufferedOutput;

    /**
     * ConsoleCustomStyle constructor.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public function __construct(InputInterface $input, OutputInterface $output)
    {
        parent::__construct($input, $output);
        $this->bufferedOutput = new BufferedOutput($output->getVerbosity(), false, clone $output->getFormatter());
    }

    /**
     * @param string $message
     */
    public function title($message)
    {
        $this->writeln([
            sprintf('<info>%s</info>', OutputFormatter::escapeTrailingBackslash($message)),
            sprintf('<info>%s</info>', str_repeat('=', Helper::strlenWithoutDecoration($this->getFormatter(), $message))),
        ]);
    }

    /**
     * @param string $message
     */
    public function section($message)
    {
        $this->autoPrependBlock();
        $this->writeln([
            sprintf('<info>%s</info>', OutputFormatter::escapeTrailingBackslash($message)),
            sprintf('<info>%s</info>', str_repeat('-', Helper::strlenWithoutDecoration($this->getFormatter(), $message))),
        ]);
    }

    /**
     * @param array $headers
     * @param array $rows
     */
    public function table(array $headers, array $rows)
    {
        $style = clone Table::getStyleDefinition('box');
        $style->setCellHeaderFormat('<info>%s</info>');
        $style->setCellRowFormat('<comment>%s</comment>');
        $table = new Table($this);
        $table->setHeaders($headers);
        $table->setRows($rows);
        $table->setStyle($style);
        $table->render();
    }

    /**
     * @param string $message
     */
    public function text($message)
    {
        $messages = is_array($message) ? array_values($message) : [$message];
        foreach ($messages as $message) {
            $this->writeln(sprintf('<comment>%s</comment>', $message));
        }
    }

    /**
     * Auto prepend block
     */
    private function autoPrependBlock(): void
    {
        $chars = substr(str_replace(PHP_EOL, "\n", $this->bufferedOutput->fetch()), -2);
        if (!isset($chars[0])) {
            $this->newLine();

            return;
        }
        $this->newLine(2 - substr_count($chars, "\n"));
    }
}
