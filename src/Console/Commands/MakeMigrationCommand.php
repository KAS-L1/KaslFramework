<?php

namespace Kasl\KaslFw\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MakeMigrationCommand extends Command
{
    protected static $defaultName = 'make:migration';

    protected function configure(): void
    {
        $this->setName(self::$defaultName)
            ->setDescription('Create a new migration file')
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the migration.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');
        $timestamp = date('Y_m_d_His');
        $fileName = "{$timestamp}_{$name}.php";
        $migrationsPath = __DIR__ . '/../../../database/migrations';

        if (!is_dir($migrationsPath)) {
            mkdir($migrationsPath, 0777, true);
        }

        $filePath = "{$migrationsPath}/{$fileName}";

        $template = <<<PHP
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // Define your migration logic here
    }

    public function down()
    {
        // Define your rollback logic here
    }
};
PHP;

        if (file_put_contents($filePath, $template)) {
            $output->writeln("<info>Migration created: {$filePath}</info>");
            return Command::SUCCESS;
        }

        $output->writeln('<error>Failed to create the migration file.</error>');
        return Command::FAILURE;
    }
}
