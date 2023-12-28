<?php

use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;

$sourcePath = 'EXT:nc_provider_main/Resources/Public/Backend/ContentElements/';

return [
    'content-Styleguide' => [
        'provider' => SvgIconProvider::class,
        'source' => $sourcePath . 'Styleguide.svg',
    ],
    'content-AccordionGroup' => [
        'provider' => SvgIconProvider::class,
        'source' => $sourcePath . 'AccordionGroup.svg',
    ],
    'content-PageTeaser' => [
        'provider' => SvgIconProvider::class,
        'source' => $sourcePath . 'PageTeaser.svg',
    ],
    'content-ImageGallery' => [
        'provider' => SvgIconProvider::class,
        'source' => $sourcePath . 'ImageGallery.svg',
    ],
    'content-ImageText' => [
        'provider' => SvgIconProvider::class,
        'source' => $sourcePath . 'ImageText.svg',
    ],
];
