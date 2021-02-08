<?php

declare(strict_types=1);

namespace JeroenG\Hummingbird\Domain\Validators;

use JeroenG\Hummingbird\Application\ParserInterface;

final class ViewportMetaTag implements ValidatorInterface
{
    public function validate(ParserInterface $parser): bool
    {
        $document = $parser->find('meta[name=viewport]');

        if ($document->count() !== 1) {
            return false;
        }

        $tag = $document->firstElement();

        return $tag?->contains('width') && $tag?->contains('initial-scale');
    }

    public function getSubject(): string
    {
        return 'The page has a <meta name="viewport"> tag with width and initial-scale properties.';
    }

    public function getErrorMessage(): string
    {
        return 'Your page has no correctly configured <meta name="viewport"> tag.';
    }
}
