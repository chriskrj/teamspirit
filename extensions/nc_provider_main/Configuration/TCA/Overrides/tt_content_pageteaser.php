<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;


ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    ['PageTeaser', 'pageteaser', 'content-PageTeaser'],
    'html',
    'after'
);

$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['pageteaser'] = 'content-PageTeaser';
$GLOBALS['TCA']['tt_content']['types']['pageteaser'] = [
    'showitem' => '
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                    --palette--;;general,
                    --palette--;;header,
                    pages,
                --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
                    --palette--;;frames,
                    tx_listelements_layout,
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
        'pages' => [
            'config' => [
                'size' => 6,
                'maxitems' => 24,
            ],
        ],
    ],
];

