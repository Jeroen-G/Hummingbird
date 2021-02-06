<?php

namespace JeroenG\Hummingbird\Tests\Unit;

use InvalidArgumentException;
use JeroenG\Hummingbird\Domain\Document;
use JeroenG\Hummingbird\Domain\Element;
use PHPUnit\Framework\TestCase;

final class DocumentTest extends TestCase
{
    public function test_it_only_accepts_an_array_of_elements(): void
    {
        $element = new Element('<p>test</p>', 'test');
        $valid = new Document([$element]);

        self::assertSame([$element], $valid->getElements());

        $this->expectException(InvalidArgumentException::class);
        new Document(['test']);
    }
}
