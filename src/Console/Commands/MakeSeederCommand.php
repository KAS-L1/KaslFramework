<?php

namespace Kasl\KaslFw\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MakeSeederCommand extends Command
{
    protected static $defaultName = 'make:seeder';

    protected function configure(): void
    {
        $this->setName('make:seeder') // Explicitly set the command name
            ->setDescription('Create a new seeder class')
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the seeder.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = ucfirst($input->getArgument('name'));
        $filePath = __DIR__ . '/../../../database/seeders/' . $name . '.php';

        if (file_exists($filePath)) {
            $output->writeln("<error>Seeder {$name} already exists.</error>");
            return Command::FAILURE;
        }

        $template = <<<PHP
<?php

namespace Kasl\KaslFw\Database\Seeders;

use Illuminate\Database\Seeder;

class {$name} extends Seeder
{
    public function run()
    {
        // Seeder logic here
    }
}
PHP;

        if (!is_dir(dirname($filePath))) {
            mkdir(dirname($filePath), 0777, true);
        }

        file_put_contents($filePath, $template);
        $output->writeln("<info>Seeder {$name} created successfully at {$filePath}.</info>");
        return Command::SUCCESS;
    }
}
