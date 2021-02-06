<?php

namespace JeroenG\Hummingbird\Tests\Unit;

use JeroenG\Hummingbird\Application\ParserInterface;
use JeroenG\Hummingbird\Tests\Support\WithCollector;
use PHPUnit\Framework\TestCase;

class CollectorTest extends TestCase
{
    use WithCollector;

    public function test_it_can_collect_data_from_string(): void
    {
        $data = $this->collector()->collect('<p>Test</p>');

        self::assertInstanceOf(ParserInterface::class, $data);
    }
}
