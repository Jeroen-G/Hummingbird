<?php

namespace JeroenG\Hummingbird\Tests\Integration\Validators;

use JeroenG\Hummingbird\Domain\Validators\ImagesMustHaveAnAltTag;
use JeroenG\Hummingbird\Domain\Validators\MaximumTitleTagLength;
use JeroenG\Hummingbird\Tests\Support\WithCollector;
use PHPUnit\Framework\TestCase;

class ImagesMustHaveAnAltTagTest extends TestCase
{
    use WithCollector;

    private ImagesMustHaveAnAltTag $validator;

    protected function setUp(): void
    {
        $this->validator = new ImagesMustHaveAnAltTag();
    }

    public function test_it_finds_a_valid_image(): void
    {
        $parser = $this->collector()->collect('<img src="test.jpg" alt="Test image" />');
        $result = $this->validator->validate($parser);

        self::assertTrue($result);
    }

    public function test_it_finds_an_image_without_alt_tag(): void
    {
        $parser = $this->collector()->collect('<img src="test.jpg" />');
        $result = $this->validator->validate($parser);

        self::assertFalse($result);
    }
}
