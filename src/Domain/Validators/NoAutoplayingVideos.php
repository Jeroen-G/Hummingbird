<?php

declare(strict_types=1);

namespace JeroenG\Hummingbird\Domain\Validators;

use JeroenG\Hummingbird\Application\ParserInterface;

final class NoAutoplayingVideos implements ValidatorInterface
{
    public function validate(ParserInterface $parser): bool
    {
        $videoTags = $parser->find('video');

        foreach ($videoTags->getElements() as $element) {
            if ($element->contains('autoplay')) {
                return false;
            }
        }

        $iFrameTags = $parser->find('iframe');

        foreach ($iFrameTags->getElements() as $element) {
            if ($element->contains('autoplay')) {
                return false;
            }
        }

        return true;
    }

    public function getSubject(): string
    {
        return 'There are no autoplaying videos on the page.';
    }

    public function getErrorMessage(): string
    {
        return 'Autoplaying videos are bad for a11y reasons, and *really* annoying.';
    }
}
