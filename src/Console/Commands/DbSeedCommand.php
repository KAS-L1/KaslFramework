<?php

namespace Kasl\KaslFw\Console\Commands;

use Illuminate\Database\Seeder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DbSeedCommand extends Command
{
    protected static $defaultName = 'db:seed';

    protected function configure(): void
    {
        $this->setName('db:seed')
            ->setDescription('Run the database seeders.')
            ->setHelp('This command executes all registered seeders to populate your database with test data.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Ensure the main seeder file exists
        $seederFile = __DIR__ . '/../../../database/seeders/DatabaseSeeder.php';

        if (!file_exists($seederFile)) {
            $output->writeln('<error>DatabaseSeeder.php file not found.</error>');
            return Command::FAILURE;
        }

        require_once $seederFile;

        // Check if DatabaseSeeder class exists
        if (!class_exists('Kasl\\KaslFw\\Database\\Seeders\\DatabaseSeeder')) {
            $output->writeln('<error>DatabaseSeeder class not found in DatabaseSeeder.php.</error>');
            return Command::FAILURE;
        }

        // Run the DatabaseSeeder
        $seeder = new \Kasl\KaslFw\Database\Seeders\DatabaseSeeder();
        $seeder->run();

        $output->writeln('<info>Database seeding completed successfully!</info>');
        return Command::SUCCESS;
    }
}
