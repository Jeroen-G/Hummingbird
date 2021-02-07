<?php

namespace JeroenG\Hummingbird\Tests\Integration\Validators;

use JeroenG\Hummingbird\Domain\Validators\MaximumTitleTagLength;
use JeroenG\Hummingbird\Tests\Support\WithCollector;
use PHPUnit\Framework\TestCase;

final class MaximumTitleTagLengthTest extends TestCase
{
    use WithCollector;

    private MaximumTitleTagLength $validator;

    protected function setUp(): void
    {
        $this->validator = new MaximumTitleTagLength();
    }

    public function test_it_finds_and_counts_the_title_tag(): void
    {
        $parser = $this->collector()->collect('<head><title>'.str_repeat('a', 54).'</title></head>');
        $result = $this->validator->validate($parser);

        self::assertTrue($result);
    }

    public function test_it_fails_when_the_title_tag_is_too_long(): void
    {
        $parser = $this->collector()->collect('<head><title>'.str_repeat('a', 56).'</title></head>');
        $result = $this->validator->validate($parser);

        self::assertFalse($result);
    }
}
