<?php

namespace Kasl\KaslFw\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MigrateRefreshCommand extends Command
{
    protected static $defaultName = 'migrate:refresh';

    protected function configure(): void
    {
        $this->setName(self::$defaultName)
            ->setDescription('Rollback all migrations and re-run them.')
            ->setHelp('This command rolls back all migrations and then re-runs them.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $application = $this->getApplication();
        if (!$application) {
            $output->writeln('<error>Application is not set in the command.</error>');
            return Command::FAILURE;
        }

        // Rollback all migrations
        $rollbackCommand = $application->find('migrate:reset');
        $rollbackInput = new ArrayInput([]);
        $rollbackResult = $rollbackCommand->run($rollbackInput, $output);
        if ($rollbackResult !== Command::SUCCESS) {
            $output->writeln('<error>Failed to rollback migrations.</error>');
            return $rollbackResult;
        }

        // Re-run migrations
        $migrateCommand = $application->find('migrate');
        $migrateInput = new ArrayInput([]);
        $migrateResult = $migrateCommand->run($migrateInput, $output);
        if ($migrateResult !== Command::SUCCESS) {
            $output->writeln('<error>Failed to re-run migrations.</error>');
            return $migrateResult;
        }

        $output->writeln('<info>All migrations have been refreshed.</info>');
        return Command::SUCCESS;
    }
}
