<?php

declare(strict_types=1);

namespace JeroenG\Hummingbird\Tests\Integration\Validators;

use JeroenG\Hummingbird\Domain\Validators\ViewportMetaTag;
use JeroenG\Hummingbird\Tests\Support\WithCollector;
use PHPUnit\Framework\TestCase;

class ViewportMetaTagTest extends TestCase
{
    use WithCollector;

    private ViewportMetaTag $validator;

    protected function setUp(): void
    {
        $this->validator = new ViewportMetaTag();
    }

    public function test_it_finds_a_viewport_meta_tag(): void
    {
        $parser = $this->collector()->collect(
            '<head><meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/></head>'
        );
        $result = $this->validator->validate($parser);

        self::assertTrue($result);
    }

    public function test_it_fails_for_invalid_viewport_tag(): void
    {
        $parser = $this->collector()->collect(
            '<head><meta name="viewport" content="shrink-to-fit=no"/></head>'
        );
        $result = $this->validator->validate($parser);

        self::assertFalse($result);
    }
}
