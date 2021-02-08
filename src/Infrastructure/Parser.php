<?php

declare(strict_types=1);

namespace JeroenG\Hummingbird\Infrastructure;

use JeroenG\Hummingbird\Application\ParserInterface;
use JeroenG\Hummingbird\Domain\Document;
use JeroenG\Hummingbird\Domain\Element;
use PHPHtmlParser\Contracts\DomInterface;
use PHPHtmlParser\Dom\Node\AbstractNode;
use PHPHtmlParser\Dom\Node\Collection;

final class Parser implements ParserInterface
{
    public function __construct(
        private DomInterface $dom
    ) {
    }

    public function find(string $selector): Document
    {
        $found = $this->dom->find($selector);

        if ($found === null) {
            return new Document([]);
        }

        if ($found instanceof Collection) {
            return new Document($this->mapArray($found->toArray()));
        }

        return new Document([$this->mapElement($found)]);
    }

    private function mapElement(AbstractNode $node): Element
    {
        return new Element($node->outerHtml(), $node->innerHtml(), $node->getAttributes());
    }

    private function mapArray(array $found): array
    {
        return array_map(fn ($item) => $this->mapElement($item), $found);
    }
}
