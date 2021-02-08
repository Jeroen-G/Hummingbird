<?php

declare(strict_types=1);

namespace JeroenG\Hummingbird\Domain;

final class Element
{
    public function __construct(
        private string $html,
        private string $content,
        private array $attributes,
    ) {
    }

    public function getHtml(): string
    {
        return $this->html;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function getAttribute(string $name): ?string
    {
        return $this->attributes[$name] ?? null;
    }

    public function contains(string $needle): bool
    {
        return str_contains($this->getHtml(), $needle);
    }
}
