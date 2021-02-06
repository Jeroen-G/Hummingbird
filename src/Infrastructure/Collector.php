<?php

declare(strict_types=1);

namespace JeroenG\Hummingbird\Infrastructure;

use JeroenG\Hummingbird\Application\CollectorInterface;
use PHPHtmlParser\Contracts\DomInterface;

final class Collector implements CollectorInterface
{
    public function __construct(
        private DomInterface $dom
    ){}

    public function collect(string $source, string $type = self::PARSE_STRING): Parser
    {
        $dom = match ($type) {
            self::PARSE_URL => $this->dom->loadFromUrl($source),
            self::PARSE_FILE => $this->dom->loadFromFile($source),
            default => $this->dom->loadStr($source),
        };


        return new Parser($dom);
    }
}
