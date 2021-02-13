<?php

declare(strict_types=1);

namespace JeroenG\Hummingbird\Tests\Integration\Validators;

use JeroenG\Hummingbird\Domain\Validators\CanonicalLink;
use JeroenG\Hummingbird\Tests\Support\WithCollector;
use PHPUnit\Framework\TestCase;

class CanonicalLinkTest extends TestCase
{
    use WithCollector;

    private CanonicalLink $validator;

    protected function setUp(): void
    {
        $this->validator = new CanonicalLink();
    }

    public function test_it_can_find_a_canonical_link(): void
    {
        $parser = $this->collector()->collect('<link rel="canonical" href="https://enrise.com" />');
        $result = $this->validator->validate($parser);

        self::assertTrue($result);

        $parser = $this->collector()->collect('<a rel="canonical" href="https://example.com">Weird link</a>');
        $result = $this->validator->validate($parser);

        self::assertFalse($result);
    }
}
