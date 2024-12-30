<?php

namespace Kasl\KaslFw\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MakeModelCommand extends Command
{
    protected static $defaultName = 'make:model';

    protected function configure(): void
    {
        $this->setName(self::$defaultName)
            ->setDescription('Create a new model class')
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the model.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = ucfirst($input->getArgument('name'));
        $filePath = __DIR__ . '/../../Models/' . $name . '.php';

        if (file_exists($filePath)) {
            $output->writeln("<error>Model {$name} already exists.</error>");
            return Command::FAILURE;
        }

        $template = <<<PHP
<?php

namespace Kasl\KaslFw\Models;

use Illuminate\Database\Eloquent\Model;

class {$name} extends Model
{
    // Define your model properties and relationships here
}
PHP;

        if (!is_dir(dirname($filePath))) {
            mkdir(dirname($filePath), 0777, true);
        }

        file_put_contents($filePath, $template);

        $output->writeln("<info>Model {$name} created successfully.</info>");
        return Command::SUCCESS;
    }
}
