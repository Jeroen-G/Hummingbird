<?php

namespace JeroenG\Hummingbird\Domain\Validators;

use JeroenG\Hummingbird\Application\ParserInterface;
use JeroenG\Hummingbird\Domain\Element;

final class OpenGraphRequiredMetaTags implements ValidatorInterface
{
    private array $openGraphs = ['description', 'image', 'title', 'type', 'url'];

    public function validate(ParserInterface $parser): bool
    {
        $document = $parser->find('meta');

        if ($document->count() < count($this->openGraphs)) {
            return false;
        }

        /** @var Element $tag */
        foreach ($document->getElements() as $tag) {
            if (!$this->singleTagIsValid($tag)) {
                return false;
            }
        }

        return true;
    }

    private function singleTagIsValid(Element $tag): bool
    {
        foreach ($this->openGraphs as $openGraph) {
            if ($tag->contains($openGraph)) {
                return true;
            }
        }

        return false;
    }

    public function getSubject(): string
    {
        return 'All the open graph tags are present in the head.';
    }

    public function getErrorMessage(): string
    {
        return 'Your page is missing the open graph description, image, title, type, or url.';
    }
}
