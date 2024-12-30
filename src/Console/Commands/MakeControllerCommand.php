<?php

namespace Kasl\KaslFw\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MakeControllerCommand extends Command
{
    protected static $defaultName = 'make:controller';

    protected function configure(): void
    {
        $this->setName(self::$defaultName)
            ->setDescription('Create a new controller class')
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the controller.')
            ->addOption('resource', 'r', InputOption::VALUE_NONE, 'Generate a resource controller.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = ucfirst($input->getArgument('name')) . 'Controller';
        $filePath = __DIR__ . '/../../Controllers/' . $name . '.php';

        if (file_exists($filePath)) {
            $output->writeln("<error>Controller {$name} already exists.</error>");
            return Command::FAILURE;
        }

        $template = $this->getTemplate($name, $input->getOption('resource'));

        if (!is_dir(dirname($filePath))) {
            mkdir(dirname($filePath), 0777, true);
        }

        file_put_contents($filePath, $template);

        $output->writeln("<info>Controller {$name} created successfully.</info>");
        return Command::SUCCESS;
    }

    private function getTemplate(string $name, bool $isResource): string
    {
        if ($isResource) {
            return <<<PHP
<?php

namespace Kasl\KaslFw\Controllers;

class {$name}
{
    public function index()
    {
        // Show a list of resources
    }

    public function create()
    {
        // Show a form to create a new resource
    }

    public function store()
    {
        // Store a new resource
    }

    public function show(\$id)
    {
        // Show a single resource
    }

    public function edit(\$id)
    {
        // Show a form to edit a resource
    }

    public function update(\$id)
    {
        // Update a resource
    }

    public function destroy(\$id)
    {
        // Delete a resource
    }
}
PHP;
        }

        return <<<PHP
<?php

namespace Kasl\KaslFw\Controllers;

class {$name}
{
    public function index()
    {
        // Define your controller logic here
    }
}
PHP;
    }
}
