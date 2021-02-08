<?php

declare(strict_types=1);

namespace JeroenG\Hummingbird\Tests\Integration\Validators;

use JeroenG\Hummingbird\Domain\Validators\RequireHtmlLang;
use JeroenG\Hummingbird\Tests\Support\WithCollector;
use PHPUnit\Framework\TestCase;

class RequireHtmlLangTest extends TestCase
{
    use WithCollector;

    private RequireHtmlLang $validator;

    protected function setUp(): void
    {
        $this->validator = new RequireHtmlLang();
    }

    public function test_it_passes_on_valid_document(): void
    {
        $parser = $this->collector()->collect('<html lang="nl"></html>');
        $result = $this->validator->validate($parser);

        self::assertTrue($result);
    }

    public function test_it_fails_on_missing_html_tag(): void
    {
        $parser = $this->collector()->collect('<head></head><body></body>');
        $result = $this->validator->validate($parser);

        self::assertFalse($result);
        self::assertStringContainsStringIgnoringCase('no <html>', $this->validator->getErrorMessage());
    }

    public function test_it_fails_on_multiple_html_tags(): void
    {
        $parser = $this->collector()->collect('<html></html><html></html>');
        $result = $this->validator->validate($parser);

        self::assertFalse($result);
        self::assertStringContainsStringIgnoringCase('multiple <html> tags', $this->validator->getErrorMessage());
    }

    public function test_it_fails_on_no_lang_attr(): void
    {
        $parser = $this->collector()->collect('<html><head><body></body></head></html>');
        $result = $this->validator->validate($parser);

        self::assertFalse($result);
        self::assertStringContainsStringIgnoringCase('no lang attr', $this->validator->getErrorMessage());
    }

    public function test_it_fails_on_empty_lang_attr(): void
    {
        $parser = $this->collector()->collect('<html lang=""><head><body></body></head></html>');
        $result = $this->validator->validate($parser);

        self::assertFalse($result);
        self::assertStringContainsStringIgnoringCase('invalid lang attr', $this->validator->getErrorMessage());
    }

    public function test_it_fails_on_invalid_lang_attr(): void
    {
        $parser = $this->collector()->collect('<html lang="nederland"><head><body></body></head></html>');
        $result = $this->validator->validate($parser);

        self::assertFalse($result);
        self::assertStringContainsStringIgnoringCase('invalid lang attr', $this->validator->getErrorMessage());
    }
}
