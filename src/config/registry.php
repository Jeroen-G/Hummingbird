<?php

use JeroenG\Hummingbird\Domain\Validators;

return [
    'h1' => Validators\AllowOnlyOneH1::class,
    'og' => Validators\OpenGraphRequiredMetaTags::class,
    'title' => Validators\MaximumTitleTagLength::class,
    'alt' => Validators\ImagesMustHaveAnAltTag::class,
];
