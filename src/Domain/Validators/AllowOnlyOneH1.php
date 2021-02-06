<?php

namespace JeroenG\Hummingbird\Domain\Validators;

use JeroenG\Hummingbird\Application\ParserInterface;

final class AllowOnlyOneH1 implements ValidatorInterface
{
    public function validate(ParserInterface $parser): bool
    {
        return $parser->find('h1')->count() <= 1;
    }

    public function getSubject(): string
    {
        return 'There should only be one <h1> tag.';
    }

    public function getErrorMessage(): string
    {
        return 'Your page does not contain at most one <h1> tag.';
    }
}
