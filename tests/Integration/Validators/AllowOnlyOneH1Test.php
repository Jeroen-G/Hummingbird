<?php

declare(strict_types=1);

namespace JeroenG\Hummingbird\Tests\Integration\Validators;

use JeroenG\Hummingbird\Domain\Validators\AllowOnlyOneH1;
use JeroenG\Hummingbird\Tests\Support\WithCollector;
use PHPUnit\Framework\TestCase;

final class AllowOnlyOneH1Test extends TestCase
{
    use WithCollector;

    private AllowOnlyOneH1 $validator;

    protected function setUp(): void
    {
        $this->validator = new AllowOnlyOneH1();
    }

    public function test_it_find_the_h1_tag(): void
    {
        $parser = $this->collector()->collect('<h1>Welcome to my website</h1>');
        $result = $this->validator->validate($parser);

        self::assertTrue($result);
    }
}
