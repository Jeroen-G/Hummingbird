<?php

declare(strict_types=1);

namespace JeroenG\Hummingbird\Tests\Integration\Validators;

use JeroenG\Hummingbird\Domain\Validators\MetaDescriptionLength;
use JeroenG\Hummingbird\Tests\Support\WithCollector;
use PHPUnit\Framework\TestCase;

class MetaDescriptionLengthTest extends TestCase
{
    use WithCollector;

    private MetaDescriptionLength $validator;

    protected function setUp(): void
    {
        $this->validator = new MetaDescriptionLength();
    }

    public function test_it_passes_valid_description(): void
    {
        $text = str_repeat('word ', 20) . '.';
        $parser = $this->collector()->collect('<meta name="description" content="' . $text . '" />');

        $result = $this->validator->validate($parser);

        self::assertTrue($result);
    }

    public function test_it_fails_on_missing_description(): void
    {
        $parser = $this->collector()->collect('<html><head></head></html>');

        $result = $this->validator->validate($parser);

        self::assertFalse($result);
        self::assertStringContainsStringIgnoringCase(
            'no <meta name="description"> found in page',
            $this->validator->getErrorMessage()
        );
    }

    public function test_it_fails_on_too_short_description(): void
    {
        $parser = $this->collector()->collect('<meta name="description" content="word word" />');

        $result = $this->validator->validate($parser);

        self::assertFalse($result);
        self::assertStringContainsStringIgnoringCase(
            'must have a length between 50 and 160',
            $this->validator->getErrorMessage()
        );
    }

    public function test_it_fails_on_too_long_description(): void
    {
        $text = str_repeat('word ', 50) . '.';
        $parser = $this->collector()->collect('<meta name="description" content="' . $text . '" />');

        $result = $this->validator->validate($parser);

        self::assertFalse($result);
        self::assertStringContainsStringIgnoringCase(
            'must have a length between 50 and 160',
            $this->validator->getErrorMessage()
        );
    }

    public function test_it_fails_on_empty_description(): void
    {
        $parser = $this->collector()->collect('<meta name="description" />');

        $result = $this->validator->validate($parser);

        self::assertFalse($result);
        self::assertStringContainsStringIgnoringCase(
            'must have a length between 50 and 160',
            $this->validator->getErrorMessage()
        );
    }
}
