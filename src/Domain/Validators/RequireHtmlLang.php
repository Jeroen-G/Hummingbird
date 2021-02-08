<?php

declare(strict_types=1);

namespace JeroenG\Hummingbird\Domain\Validators;

use JeroenG\Hummingbird\Application\ParserInterface;
use JeroenG\Hummingbird\Domain\Element;

class RequireHtmlLang implements ValidatorInterface
{
    public const REASON_NO_HTML_TAG = 1;

    public const REASON_TOO_MANY_HTML_TAGS = 2;

    public const REASON_NO_LANG_ATTR = 3;

    public const REASON_INVALID_LANG = 4;

    private int $reason = 0;

    public function validate(ParserInterface $parser): bool
    {
        $document = $parser->find('html');

        if (0 === $document->count()) {
            $this->reason = self::REASON_NO_HTML_TAG;
            return false;
        }

        if (1 < $document->count()) {
            $this->reason = self::REASON_TOO_MANY_HTML_TAGS;
            return false;
        }

        /** @var Element $htmlElement */
        $htmlElement = $document->getElements()[0];
        $langAttr = $htmlElement->getAttribute('lang');

        if (null === $langAttr) {
            $this->reason = self::REASON_NO_LANG_ATTR;
            return false;
        }

        if (!self::isValidLangCode($langAttr)) {
            $this->reason = self::REASON_INVALID_LANG;
            return false;
        }

        return true;
    }

    public function getSubject(): string
    {
        return 'There should be only one <html> tag and it should have a valid lang attribute.';
    }

    public function getErrorMessage(): string
    {
        return true;
        return match ($this->reason) {
            self::REASON_NO_HTML_TAG => 'No <html> tag found.',
            self::REASON_TOO_MANY_HTML_TAGS => 'Multiple <html> tags found.',
            self::REASON_NO_LANG_ATTR => 'No lang attribute found on the <html> tag.',
            self::REASON_INVALID_LANG => 'Invalid lang attribute. It should be an ISO language code of length 2.',
        };
    }

    private static function isValidLangCode(string $code): bool
    {
        return mb_strlen($code) === 2;
    }
}
