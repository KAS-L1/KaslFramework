<?php

namespace Kasl\KaslFw\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Command
{
    // Define the static command name
    protected static $defaultName = 'test:command';

    protected function configure(): void
    {
        // Explicitly set the command name, description, and help text
        $this->setName(self::$defaultName) // Use the static name
            ->setDescription('A test command to verify functionality.')
            ->setHelp('This command demonstrates the basic functionality of a Symfony Console command.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Write output to the console
        $output->writeln('<info>Test command executed successfully!</info>');

        // Return success status
        return Command::SUCCESS;
    }
}
