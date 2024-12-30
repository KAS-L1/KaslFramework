<?php

namespace Kasl\KaslFw\Console\Commands;

use Illuminate\Database\Capsule\Manager as Capsule;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RollbackCommand extends Command
{
    // Define the static command name
    protected static $defaultName = 'migrate:rollback';

    protected function configure(): void
    {
        // Explicitly set the command name, description, and help text
        $this->setName(self::$defaultName) // Use the static name
            ->setDescription('Rollback the last database migration.')
            ->setHelp('This command rolls back the last applied database migration.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Ensure the migrations table exists
        if (!Capsule::schema()->hasTable('migrations')) {
            $output->writeln("<comment>No migrations to rollback.</comment>");
            return Command::SUCCESS;
        }

        $lastMigration = Capsule::table('migrations')->orderBy('id', 'desc')->first();
        if (!$lastMigration) {
            $output->writeln("<comment>No migrations to rollback.</comment>");
            return Command::SUCCESS;
        }

        $className = $lastMigration->migration;
        $migrationsPath = __DIR__ . '/../../../database/migrations';

        $file = "{$migrationsPath}/{$className}.php";
        if (!file_exists($file)) {
            $output->writeln("<error>Migration file {$className} not found.</error>");
            return Command::FAILURE;
        }

        require_once $file;
        if (!class_exists($className)) {
            $output->writeln("<error>Migration class {$className} not found in file {$file}.</error>");
            return Command::FAILURE;
        }

        $migration = new $className();
        $migration->down();

        // Remove the migration record
        Capsule::table('migrations')->where('migration', $className)->delete();
        $output->writeln("<info>Migration {$className} has been rolled back.</info>");

        return Command::SUCCESS;
    }
}
