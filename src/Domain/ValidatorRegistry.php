<?php

declare(strict_types=1);

namespace JeroenG\Hummingbird\Domain;

use JeroenG\Hummingbird\Domain\Validators\AllowOnlyOneH1;
use JeroenG\Hummingbird\Domain\Validators\OpenGraphRequiredMetaTags;

final class ValidatorRegistry
{
    public function __construct(
        private array $validators
    ){}

    public function all(): array
    {
        return $this->make($this->validators);
    }

    public function match(array $keys): array
    {
        $matches = array_filter(
            $this->validators,
            fn($key) => in_array($key, $keys, true),
            ARRAY_FILTER_USE_KEY
        );

        return $this->make($matches);
    }

    private function make(array $validators): array
    {
        return array_map(fn($validator) => new $validator(), array_values($validators));
    }
}
