<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;


defined('TYPO3') or die('Access denied.');

// Configure additional columns
$additionalColumns = [
    'headline' => [
        'label' => 'Überschrift',
        'exclude' => true,
        'description' => 'die Überschrift wird als h1 auf der Seite und als Teaser-Überschrift verwendet. Alternativ wird der Seitentitel verwendet.',
        'config' => [
            'type' => 'text',
            'eval' => 'trim',
            'max' => 255,
            'rows' => 2,
            'enableRichtext' => false,
        ],
    ],
    'linklabel' => [
        'label' => 'Alternativer Linklabel',
        'exclude' => true,
        'description' => 'Der Linklabel wird als Label in den Teasern verwendet. Alternativ wird ein allgemeiner Text verwendet.',
        'config' => [
            'type' => 'input',
            'eval' => 'trim',
            'size' => 60,
            'max' => 255,
        ],
    ],
];

ExtensionManagementUtility::addTCAcolumns('pages', $additionalColumns);

$GLOBALS['TCA']['pages']['columns']['media']['config']['overrideChildTca']['columns']['uid_local']['config']['appearance']['elementBrowserAllowed'] = 'png,jpg,jpeg';

// cropVariants
$GLOBALS['TCA']['pages']['columns']['media']['config']['overrideChildTca']['columns']['crop']['config'] = [
    'cropVariants' => [
        '21:9' => [
            'title' => '21:9',
            'allowedAspectRatios' => [
                '21:9' => [
                    'title' => '21:9',
                    'value' => 21 / 9,
                ],
            ],
        ],
        '16:9' => [
            'title' => '16:9',
            'allowedAspectRatios' => [
                '16:9' => [
                    'title' => '16:9',
                    'value' => 16 / 9,
                ],
            ],
        ],
        '4:3' => [
            'title' => '4:3',
            'allowedAspectRatios' => [
                '4:3' => [
                    'title' => '4:3',
                    'value' => 4 / 3,
                ],
            ],
        ],
    ],
];

ExtensionManagementUtility::addToAllTCAtypes(
    'pages',
    'headline',
    '1,3,4',
    'after:title'
);


// remove abstract palette
$GLOBALS['TCA']['pages']['palettes']['abstract']['showitem'] = '';

// create teaser palette
$GLOBALS['TCA']['pages']['palettes']['teaser']['showitem'] = 'abstract,--linebreak--,linklabel';

ExtensionManagementUtility::addToAllTCAtypes(
    'pages',
    '--palette--;;teaser',
    '1,3,4',
    'after:headline'
);


$GLOBALS['TCA']['pages']['columns']['media']['config']['maxitems'] = 1;

call_user_func(function (): void {
    /**
     * Temporary variables
     */
    $extensionKey = 'nc_provider_main';

    /**
     * Default PageTS for NcProviderMain
     */
    ExtensionManagementUtility::registerPageTSConfigFile(
        $extensionKey,
        'Configuration/TsConfig/Page/All.tsconfig',
        'Nc Provider Main'
    );
});
