<?php

declare(strict_types=1);

namespace JeroenG\Hummingbird\Tests\Support;

use JeroenG\Hummingbird\Infrastructure\Collector;
use PHPHtmlParser\Dom;

trait WithCollector
{
    public function collector(): Collector
    {
        return new Collector(new Dom());
    }
}
