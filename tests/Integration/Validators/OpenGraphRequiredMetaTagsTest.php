<?php

declare(strict_types=1);

namespace JeroenG\Hummingbird\Tests\Integration\Validators;

use JeroenG\Hummingbird\Domain\Validators\OpenGraphRequiredMetaTags;
use JeroenG\Hummingbird\Tests\Support\WithCollector;
use PHPUnit\Framework\TestCase;

class OpenGraphRequiredMetaTagsTest extends TestCase
{
    use WithCollector;

    private OpenGraphRequiredMetaTags $validator;

    protected function setUp(): void
    {
        $this->validator = new OpenGraphRequiredMetaTags();
    }

    public function test_it_finds_the_open_graph_meta_tags(): void
    {
        $parser = $this->collector()->collect('
            <meta charset="utf-8" />
            <meta property="og:type" content="website">
            <meta property="og:title" content="Testing a class">
            <meta property="og:description" content="Testing a class with OG tags">
            <meta property="og:image" content="https://example.com/images/opengraph.jpg">
            <meta property="og:url" content="https://example.com">
        ');

        $result = $this->validator->validate($parser);

        self::assertTrue($result);
    }

    public function test_it_finds_missing_open_graph_tags(): void
    {
        $parser = $this->collector()->collect('<meta property="og:type" content="website">');

        $result = $this->validator->validate($parser);

        self::assertFalse($result);
    }
}
