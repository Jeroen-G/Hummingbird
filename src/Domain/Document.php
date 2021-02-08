<?php

declare(strict_types=1);

namespace JeroenG\Hummingbird\Domain;

use Webmozart\Assert\Assert;

final class Document
{
    private array $elements;

    public function __construct(array $elements)
    {
        Assert::allIsInstanceOf($elements, Element::class);

        $this->elements = $elements;
    }

    public function getElements(): array
    {
        return $this->elements;
    }

    public function firstElement(): ?Element
    {
        return $this->elements[0];
    }

    public function count(): int
    {
        return count($this->getElements());
    }
}
