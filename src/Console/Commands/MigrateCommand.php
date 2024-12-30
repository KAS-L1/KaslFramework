<?php

namespace Kasl\KaslFw\Console\Commands;

use Illuminate\Database\Capsule\Manager as Capsule;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MigrateCommand extends Command
{
    protected static $defaultName = 'migrate';

    protected function configure(): void
    {
        $this->setName(self::$defaultName)
            ->setDescription('Run database migrations.')
            ->setHelp('This command executes all pending migrations in the database/migrations directory.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $migrationsPath = __DIR__ . '/../../../database/migrations';

        // Ensure the `migrations` table exists
        if (!Capsule::schema()->hasTable('migrations')) {
            Capsule::schema()->create('migrations', function ($table) {
                $table->id();
                $table->string('migration');
                $table->timestamp('created_at')->useCurrent();
            });
            $output->writeln('<info>Created migrations table.</info>');
        }

        if (!is_dir($migrationsPath)) {
            $output->writeln('<error>Migrations directory does not exist.</error>');
            return Command::FAILURE;
        }

        $files = scandir($migrationsPath);
        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                $output->writeln("<info>Detected migration file: {$file}</info>");

                $baseName = pathinfo($file, PATHINFO_FILENAME);
                $className = $this->getClassNameFromFile($migrationsPath . '/' . $file);

                if (!$className) {
                    $output->writeln("<error>Failed to detect a valid class in file {$file}.</error>");
                    continue;
                }

                $output->writeln("<info>Generated class name: {$className}</info>");

                // Check if migration has already been applied
                $applied = Capsule::table('migrations')->where('migration', $baseName)->exists();
                if ($applied) {
                    $output->writeln("<comment>Migration {$className} already applied.</comment>");
                    continue;
                }

                require_once $migrationsPath . '/' . $file;

                if (!class_exists($className)) {
                    $output->writeln("<error>Migration class {$className} not found in file {$file}.</error>");
                    continue;
                }

                $migration = new $className();
                $migration->up();

                // Record the migration
                Capsule::table('migrations')->insert(['migration' => $baseName]);
                $output->writeln("<info>Migration {$className} has been applied.</info>");
            }
        }

        return Command::SUCCESS;
    }

    private function getClassNameFromFile(string $filePath): ?string
    {
        $fileContent = file_get_contents($filePath);

        // Match the class name that extends Migration
        if (preg_match('/class\s+(\w+)\s+extends\s+Migration/', $fileContent, $matches)) {
            return $matches[1]; // Return the class name
        }

        return null; // Return null if no match is found
    }
}
