<?php

declare(strict_types=1);

namespace JeroenG\Hummingbird\Application;

interface CollectorInterface
{
    public const PARSE_URL = 'url';

    public const PARSE_FILE = 'file';

    public const PARSE_STRING = 'string';

    public function collect(string $source, string $type = self::PARSE_STRING): ParserInterface;
}
