<?php

declare(strict_types=1);

namespace JeroenG\Hummingbird\Domain\Validators;

use JeroenG\Hummingbird\Application\ParserInterface;
use JeroenG\Hummingbird\Domain\Element;

final class LinksMustHaveDescriptiveText implements ValidatorInterface
{
    /* @see https://web.dev/link-text */
    private array $generics = [
        'click here',
        'click this',
        'go',
        'here',
        'learn more',
        'more',
        'right here',
        'start',
        'this',
    ];

    public function validate(ParserInterface $parser): bool
    {
        $document = $parser->find('a');

        foreach ($document->getElements() as $element) {
            if (!$this->validateSingleElement($element)) {
                return false;
            }
        }

        return true;
    }

    public function getSubject(): string
    {
        return 'Every link has a descriptive text.';
    }

    public function getErrorMessage(): string
    {
        return 'You have links with too generic texts on your page.';
    }

    private function validateSingleElement(Element $element): bool
    {
        foreach ($this->generics as $generic) {
            if (self::equalize($element->getContent()) === self::equalize($generic)) {
                return false;
            }
        }

        return true;
    }

    private static function equalize(string $text): string
    {
        return mb_strtolower(preg_replace('/\s+/', '', $text));
    }
}
