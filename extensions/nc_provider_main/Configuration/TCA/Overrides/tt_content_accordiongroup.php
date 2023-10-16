<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Resource\File;

ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    ['AccordionGroup', 'accordiongroup', 'content-AccordionGroup'],
    'html',
    'after'
);

$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['accordiongroup'] = 'content-AccordionGroup';
$GLOBALS['TCA']['tt_content']['types']['accordiongroup'] = [
    'showitem' => '
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                    --palette--;;general,
                    --palette--;;headers,
                    tx_listelements_list,
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
];

$GLOBALS['TCA']['tt_content']['types']['accordiongroup']['columnsOverrides'] = [
    'tx_listelements_list' => [
        'label' => 'Akkordeon Elemente',
        'config' => [
            'appearance' => [
                'newRecordLinkTitle' => 'Neues Akkordeon Element erstellen',
            ],
            'overrideChildTca' => [
                // add a showitem configuration for the list items for this CType
                'types' => [
                    '0' => [
                        'showitem' => '
                                header,
                                bodytext,
                                --palette--;;hiddenpalette', // always include the hidden palette (languages)
                    ],
                ],
            ],
        ],
    ],
];
