<?php

declare(strict_types=1);

use JeroenG\Hummingbird\Domain\Validators;

return [
    'h1' => Validators\AllowOnlyOneH1::class,
    'og' => Validators\OpenGraphRequiredMetaTags::class,
    'title' => Validators\MaximumTitleTagLength::class,
    'alt' => Validators\ImagesMustHaveAnAltTag::class,
    'lang' => Validators\RequireHtmlLang::class,
    'vp' => Validators\ViewportMetaTag::class,
    'atxt' => Validators\LinksMustHaveDescriptiveText::class,
    'mdesc' => Validators\MetaDescriptionLength::class,
    'canon' => Validators\CanonicalLink::class,
    'auvid' => Validators\NoAutoplayingVideos::class,

    'minimal' => ['h1', 'lang', 'alt'],
    'a11y' => ['h1', 'alt', 'atxt', 'auvid'],
    'media' => ['og', 'alt', 'auvid'],
];
