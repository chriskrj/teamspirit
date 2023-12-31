<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    ['ImageText', 'image_text', 'content-ImageText'],
    'html',
    'after'
);

$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['image_text'] = 'content-ImageText';
$GLOBALS['TCA']['tt_content']['types']['image_text'] = [
    'showitem' => '
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
            --palette--;;general,
            --palette--;;headers,
            bodytext;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:bodytext_formlabel,
            --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.media,
            assets,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
            --palette--;;frames,
            --palette--;;appearanceLinks,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
            --palette--;;language,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
            --palette--;;hidden,
            --palette--;;access,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,
            categories,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes,
            rowDescription,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
    ',
    'columnsOverrides' => [
        'bodytext' => [
            'config' => [
                'enableRichtext' => true,
            ],
        ],
        'assets' => [
            'config' => [
                'minitems' => 0,
                'maxitems' => 1,
                'allowed' => 'jpg,jpeg,png',
                'overrideChildTca' => [
                    'columns' => [
                        'crop' => [
                            'config' => [
                                'cropVariants' => [
                                    'default' => [
                                        'disabled' => true,
                                    ],
                                    '3:4' => [
                                        'title' => '3:4',
                                        'allowedAspectRatios' => [
                                            '3:4' => [
                                                'title' => '3:4',
                                                'value' =>3 / 4,
                                            ],
                                        ],
                                    ],
                                    '4:3' => [
                                        'title' => '4:3',
                                        'allowedAspectRatios' => [
                                            '4:3' => [
                                                'title' => '4:3',
                                                'value' =>4 / 3,
                                            ],
                                        ],
                                    ],
                                    '16:9' => [
                                        'title' => '16:9',
                                        'allowedAspectRatios' => [
                                            '16:9' => [
                                                'title' => '16:9',
                                                'value' =>16 / 9,
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
