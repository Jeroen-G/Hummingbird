<?php

declare(strict_types=1);

namespace JeroenG\Hummingbird\Domain\Validators;

use JeroenG\Hummingbird\Application\ParserInterface;

class CanonicalLink implements ValidatorInterface
{
    public function validate(ParserInterface $parser): bool
    {
        $document = $parser->find('link[rel=canonical]');

        return !(0 === $document->count());
    }

    public function getSubject(): string
    {
        return 'There is a <link rel="canonical"> on the page.';
    }

    public function getErrorMessage(): string
    {
        return 'There was no <link rel="canonical">, you might want to add one.';
    }
}
