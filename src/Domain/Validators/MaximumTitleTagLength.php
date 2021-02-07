<?php

namespace JeroenG\Hummingbird\Domain\Validators;

use JeroenG\Hummingbird\Application\ParserInterface;
use JeroenG\Hummingbird\Domain\Element;

final class MaximumTitleTagLength implements ValidatorInterface
{
    public function validate(ParserInterface $parser): bool
    {
        $document = $parser->find('title');

        if ($document->count() !== 1) {
            return false;
        }

        /** @var Element $tag */
        $tag = $document->getElements()[0];

        $content = $tag->getContent();

        return strlen($content) <= 55;
    }

    public function getSubject(): string
    {
        return 'The page has a <title> tag and it is at most 55 characters.';
    }

    public function getErrorMessage(): string
    {
        return 'Your page has no <title> tag or it is too long.';
    }
}
