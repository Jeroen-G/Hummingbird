<?php

namespace JeroenG\Hummingbird\Infrastructure\Console;

use JeroenG\Hummingbird\Application\CollectorInterface;
use JeroenG\Hummingbird\Domain\Validators\AllowOnlyOneH1;
use JeroenG\Hummingbird\Domain\Validators\OpenGraphRequiredMetaTags;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class EvaluateUrlCommand extends Command
{
    protected static $defaultName = 'evaluate:url';
    private CollectorInterface $collector;
    private bool $passed = true;

    public function __construct(CollectorInterface $collector)
    {
        $this->collector = $collector;

        parent::__construct();
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
        $assertions = $this->getTests($input->getOption('assertions'));

        foreach ($input->getArgument('url') as $url) {
            $this->evaluateUrl($url, $assertions, $output);
        }

        return $this->passed ? Command::SUCCESS : Command::FAILURE;
    }

    private function evaluateUrl(string $url, array $tests, OutputInterface $output): void
    {
        $output->writeln("<comment>Starting to evaluate {$url}</comment>");

        $document = $this->collector->collect($url, CollectorInterface::PARSE_URL);

        foreach ($tests as $test) {
            $output->writeln('✓ '. $test->getSubject());

            if($test->validate($document) === false) {
                $this->passed = false;
                $output->writeln("<error>An error occurred while evaluating {$url}</error>");
                $output->writeln("<error>{$test->getErrorMessage()}</error>");
            }
        }

        $output->writeln("<info>Evaluated {$url}</info>\n");
    }

    private function getTests(?string $input): array
    {
        if ($input === '' || $input === null) {
            return [new AllowOnlyOneH1(), new OpenGraphRequiredMetaTags()];
        }

        $assertions = explode(',', $input);

        $match = [];

        foreach ($assertions as $assertion) {
            $match[] = match ($assertion) {
                'h1' => new AllowOnlyOneH1(),
                'og' => new OpenGraphRequiredMetaTags(),
                default => throw new InvalidArgumentException('No assertion found for '.$assertion)
            };
        }

        return $match;
    }
}
