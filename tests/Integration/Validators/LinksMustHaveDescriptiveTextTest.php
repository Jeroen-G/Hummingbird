<?php

declare(strict_types=1);

namespace JeroenG\Hummingbird\Tests\Integration\Validators;

use JeroenG\Hummingbird\Domain\Validators\LinksMustHaveDescriptiveText;
use JeroenG\Hummingbird\Tests\Support\WithCollector;
use PHPUnit\Framework\TestCase;

class LinksMustHaveDescriptiveTextTest extends TestCase
{
    use WithCollector;

    private LinksMustHaveDescriptiveText $validator;

    protected function setUp(): void
    {
        $this->validator = new LinksMustHaveDescriptiveText();
    }

    public function test_it_finds_a_valid_link(): void
    {
        $parser = $this->collector()->collect('<a>Click here to see detailed information on a report</a>');

        $result = $this->validator->validate($parser);

        self::assertTrue($result);
    }

    public function test_it_finds_an_invalid_link(): void
    {
        $parser = $this->collector()->collect('<a>Click here</a>');

        $result = $this->validator->validate($parser);

        self::assertFalse($result);
    }
}
