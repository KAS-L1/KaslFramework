<?php

namespace Kasl\KaslFw\Console\Commands;

use Illuminate\Database\Capsule\Manager as Capsule;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MigrateResetCommand extends Command
{
    protected static $defaultName = 'migrate:reset';

    protected function configure(): void
    {
        $this->setName(self::$defaultName)
            ->setDescription('Rollback all database migrations.')
            ->setHelp('This command rolls back all migrations in the database/migrations directory.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!Capsule::schema()->hasTable('migrations')) {
            $output->writeln("<comment>No migrations table found.</comment>");
            return Command::SUCCESS;
        }

        while (true) {
            $lastMigration = Capsule::table('migrations')->orderBy('id', 'desc')->first();
            if (!$lastMigration) {
                $output->writeln("<info>All migrations have been rolled back.</info>");
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

            Capsule::table('migrations')->where('migration', $className)->delete();
            $output->writeln("<info>Migration {$className} has been rolled back.</info>");
        }
    }
}
