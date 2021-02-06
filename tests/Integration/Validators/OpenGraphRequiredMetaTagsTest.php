<?php

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
            <meta property="og:type" content="website">
            <meta property="og:title" content="Testing a class">
            <meta property="og:image" content="https://example.com/images/opengraph.jpg">
        ');

        $result = $this->validator->validate($parser);

        self::assertTrue($result);
    }
}
