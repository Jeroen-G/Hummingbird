<?php

declare(strict_types=1);

namespace JeroenG\Hummingbird\Application;

use JeroenG\Hummingbird\Domain\Document;

interface ParserInterface
{
    public function find(string $selector): Document;
}
