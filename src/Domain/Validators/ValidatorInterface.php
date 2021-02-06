<?php

namespace JeroenG\Hummingbird\Domain\Validators;

use JeroenG\Hummingbird\Application\ParserInterface;

interface ValidatorInterface
{
    public function validate(ParserInterface $parser): bool;

    /** Answer this question: "It should evaluate that..." */
    public function getSubject(): string;

    /** Answer this question: "It went wrong because..." */
    public function getErrorMessage(): string;
}
