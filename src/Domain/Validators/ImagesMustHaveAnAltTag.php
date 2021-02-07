<?php

namespace JeroenG\Hummingbird\Domain\Validators;

use JeroenG\Hummingbird\Application\ParserInterface;
use JeroenG\Hummingbird\Domain\Element;

final class ImagesMustHaveAnAltTag implements ValidatorInterface
{
    public function validate(ParserInterface $parser): bool
    {
        $document = $parser->find('img');

        /** @var Element $tag */
        foreach ($document->getElements() as $tag) {
            if (!str_contains($tag->getHtml(), 'alt')) {
                return false;
            }
        }

        return true;
    }

    public function getSubject(): string
    {
        return 'All images should have an alt tag.';
    }

    public function getErrorMessage(): string
    {
        return 'Your page has one or more images without an alt tag.';
    }
}
