<?php

namespace Kasl\KaslFw\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MakeMiddlewareCommand extends Command
{
    protected static $defaultName = 'make:middleware';

    protected function configure(): void
    {
        $this->setName('make:middleware') // Explicitly set the command name
            ->setDescription('Create a new middleware class')
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the middleware.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = ucfirst($input->getArgument('name'));
        $filePath = __DIR__ . '/../.././Http/' . $name . '.php';

        if (file_exists($filePath)) {
            $output->writeln("<error>Middleware {$name} already exists.</error>");
            return Command::FAILURE;
        }

        $template = <<<PHP
<?php

namespace Kasl\KaslFw\Middleware;

class {$name}
{
    public function handle(\$request, \$next)
    {
        // Middleware logic here
        return \$next(\$request);
    }
}
PHP;

        if (!is_dir(dirname($filePath))) {
            mkdir(dirname($filePath), 0777, true);
        }

        file_put_contents($filePath, $template);
        $output->writeln("<info>Middleware {$name} created successfully at {$filePath}.</info>");
        return Command::SUCCESS;
    }
}
