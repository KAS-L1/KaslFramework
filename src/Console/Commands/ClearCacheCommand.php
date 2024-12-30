<?php

namespace Kasl\KaslFw\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ClearCacheCommand extends Command
{
    // Define the static command name
    protected static $defaultName = 'cache:clear';

    protected function configure(): void
    {
        // Explicitly set the command name, description, and help text
        $this->setName(self::$defaultName) // Use the static name
            ->setDescription('Clears the application cache.')
            ->setHelp('This command allows you to clear cached files in the application.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $cachePath = __DIR__ . '/../../../storage/framework/cache/blade';

        if (is_dir($cachePath)) {
            $files = glob("$cachePath/*");
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }
            $output->writeln('<info>Cache cleared successfully!</info>');
        } else {
            $output->writeln('<comment>Cache directory does not exist.</comment>');
        }

        return Command::SUCCESS;
    }
}
