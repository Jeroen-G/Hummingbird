<?php

declare(strict_types=1);

namespace JeroenG\Hummingbird\Domain;

final class ValidatorRegistry
{
    public function __construct(
        private array $validators
    ) {
    }

    public function all(): array
    {
        $withoutProfiles = array_filter($this->validators, fn ($item) => !is_array($item));
        return $this->make($withoutProfiles);
    }

    public function match(array $keys): array
    {
        $matches = array_filter(
            $this->validators,
            fn ($key) => in_array($key, $keys, true),
            ARRAY_FILTER_USE_KEY
        );

        return $this->flatten($this->make($matches));
    }

    private function make(array $validators): array
    {
        return array_map(
            fn ($validator) =>
            is_array($validator)
                ? $this->match($validator)
                : new $validator(),
            array_values($validators)
        );
    }

    private function flatten(array $made): array
    {
        // If it contains a profile of validators (i.e. an array), we need to 'flatten' the results.

        foreach ($made as $key => $value) {
            if (!is_array($value)) {
                $made[$key] = [$value];
            }
        }

        return array_merge(...$made);
    }
}
