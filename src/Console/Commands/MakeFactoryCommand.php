<?php

namespace Kasl\KaslFw\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MakeFactoryCommand extends Command
{
    protected static $defaultName = 'make:factory';

    protected function configure(): void
    {
        $this->setName('make:factory') // Explicitly set the command name
            ->setDescription('Create a new factory class')
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the factory.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = ucfirst($input->getArgument('name'));
        $filePath = __DIR__ . '/../../../database/factories/' . $name . '.php';

        if (file_exists($filePath)) {
            $output->writeln("<error>Factory {$name} already exists.</error>");
            return Command::FAILURE;
        }

        $template = <<<PHP
<?php

namespace Kasl\KaslFw\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class {$name} extends Factory
{
    protected \$model = Model::class; // Replace 'Model::class' with your model class

    public function definition()
    {
        return [
            // Define your model's default state here
        ];
    }
}
PHP;

        if (!is_dir(dirname($filePath))) {
            mkdir(dirname($filePath), 0777, true);
        }

        file_put_contents($filePath, $template);
        $output->writeln("<info>Factory {$name} created successfully at {$filePath}.</info>");
        return Command::SUCCESS;
    }
}
