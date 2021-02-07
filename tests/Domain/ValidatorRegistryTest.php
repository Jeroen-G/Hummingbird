<?php

declare(strict_types=1);

namespace JeroenG\Hummingbird\Tests\Domain;

use JeroenG\Hummingbird\Domain\ValidatorRegistry;
use JeroenG\Hummingbird\Domain\Validators\AllowOnlyOneH1;
use JeroenG\Hummingbird\Domain\Validators\OpenGraphRequiredMetaTags;
use PHPUnit\Framework\TestCase;

class ValidatorRegistryTest extends TestCase
{
    public function test_it_can_get_all_validators(): void
    {
        $registry = new ValidatorRegistry([
            'h1' => AllowOnlyOneH1::class,
            'og' => OpenGraphRequiredMetaTags::class,
        ]);

        $registered = $registry->all();

        self::assertCount(2, $registered);
        self::assertInstanceOf(AllowOnlyOneH1::class, $registered[0]);
        self::assertInstanceOf(OpenGraphRequiredMetaTags::class, $registered[1]);
    }

    public function test_it_can_match_a_subset_of_validators(): void
    {
        $registry = new ValidatorRegistry([
            'h1' => AllowOnlyOneH1::class,
            'og' => OpenGraphRequiredMetaTags::class,
        ]);

        $registered = $registry->match(['h1']);

        self::assertCount(1, $registered);
        self::assertInstanceOf(AllowOnlyOneH1::class, $registered[0]);
    }
}
