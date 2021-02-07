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

        $html = implode(' ', array_map(fn(Element $element) => $element->getHtml(), $document->getElements()));

        foreach ($this->openGraphs as $openGraph) {
            if (!str_contains($html, $openGraph)) {
                return false;
            }
        }

        return true;
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
