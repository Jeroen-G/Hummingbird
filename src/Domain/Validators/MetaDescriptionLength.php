<?php

declare(strict_types=1);

namespace JeroenG\Hummingbird\Domain\Validators;

use JeroenG\Hummingbird\Application\ParserInterface;
use JeroenG\Hummingbird\Domain\Element;

/**
 * @see https://moz.com/learn/seo/meta-description#:~:text=Meta%20descriptions%20can%20be%20any,descriptions%20between%2050%E2%80%93160%20characters.
 * @see
 */
class MetaDescriptionLength implements ValidatorInterface
{
    public const REASON_NO_TAG = 1;

    public const REASON_INVALID_LENGTH = 2;

    private int $reason = 0;

    public function validate(ParserInterface $parser): bool
    {
        $document = $parser->find('meta[name=description]');

        if (0 === count($document->getElements())) {
            $this->reason = self::REASON_NO_TAG;
            return false;
        }

        /** @var Element $element */
        $content = $document->getElements()[0]->getAttribute('content') ?? '';
        $contentLength = mb_strlen($content);
        if ($contentLength < 50 || $contentLength > 160) {
            $this->reason = self::REASON_INVALID_LENGTH;
            return false;
        }

        return true;
    }

    public function getSubject(): string
    {
        return 'The page has a <meta name="description"> with content between 50-160 characters.';
    }

    public function getErrorMessage(): string
    {
        return match ($this->reason) {
            self::REASON_NO_TAG =>
                'No <meta name="description"> found in page',
            self::REASON_INVALID_LENGTH =>
                'The content of <meta name="description"> must have a length between 50 and 160 characters',
        };
    }
}
