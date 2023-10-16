<?php

defined('TYPO3') or die('Access denied.');

// background color class for content elements
$GLOBALS['TCA']['tt_content']['columns']['background_color_class'] = [
    'exclude' => true,
    'label' => 'Hintergrundfarbe',
    'config' => [
        'type' => 'select',
        'renderType' => 'selectSingle',
        'items' => [
            ['Default', 'default'],
            ['Hervorgehoben', 'accent'],
        ],
    ],
    'l10n_mode' => 'exclude',
];

// theme for content elements
$GLOBALS['TCA']['tt_content']['columns']['theme'] = [
    'exclude' => true,
    'label' => 'Theme',
    'config' => [
        'type' => 'select',
        'renderType' => 'selectSingle',
        'items' => [
            ['Hell', 'light'],
            ['Dunkel', 'dark'],
        ],
    ],
    'l10n_mode' => 'exclude',
];

// Add background_color_class to default palettes
$GLOBALS['TCA']['tt_content']['palettes']['frames']['showitem'] .= '
    --linebreak--,
    frame_layout,
    --linebreak--,
    background_color_class,
    theme,
';
