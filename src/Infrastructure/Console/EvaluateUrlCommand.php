<?php

namespace JeroenG\Hummingbird\Infrastructure\Console;

use JeroenG\Hummingbird\Application\CollectorInterface;
use JeroenG\Hummingbird\Domain\ValidatorRegistry;
use JeroenG\Hummingbird\Domain\Validators\AllowOnlyOneH1;
use JeroenG\Hummingbird\Domain\Validators\OpenGraphRequiredMetaTags;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class EvaluateUrlCommand extends Command
{
    protected static $defaultName = 'evaluate:url';
    private CollectorInterface $collector;
    private bool $passed = true;
    private ValidatorRegistry $validatorRegistry;

    public function __construct(CollectorInterface $collector, ValidatorRegistry $validatorRegistry)
    {
        $this->collector = $collector;

        parent::__construct();
        $this->validatorRegistry = $validatorRegistry;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Evaluate')
            ->addArgument('url', InputArgument::IS_ARRAY, 'URL(s) to the page(s) you want to evaluate.')
            ->addOption('assertions', 'a', InputOption::VALUE_OPTIONAL, 'Define a comma separated custom set of assertions.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $assertions = $this->getValidators($input->getOption('assertions'));

        foreach ($input->getArgument('url') as $url) {
            $this->evaluateUrl($url, $assertions, $output);
        }

        return $this->passed ? Command::SUCCESS : Command::FAILURE;
    }

    private function evaluateUrl(string $url, array $assertions, OutputInterface $output): void
    {
        $output->writeln("<comment>Starting to evaluate {$url}</comment>");

        $document = $this->collector->collect($url, CollectorInterface::PARSE_URL);

        foreach ($assertions as $validator) {
            if($validator->validate($document) === false) {
                $this->passed = false;
                $output->writeln("<error>{$validator->getErrorMessage()}</error>");
                continue;
            }

            $output->writeln('✓ '. $validator->getSubject());
        }

        $output->writeln("<info>Evaluated {$url}</info>\n");
    }

    private function getValidators(?string $input): array
    {
        if ($input === '' || $input === null) {
            return $this->validatorRegistry->all();
        }

        return $this->validatorRegistry->match(explode(',', $input));
    }
}
