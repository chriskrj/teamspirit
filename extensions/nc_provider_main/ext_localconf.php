<?php
defined('TYPO3') or die('Access denied.');

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use NC\NcProviderMain\Backend\PageLayoutHeader;
use NC\NcProviderMain\Hooks\ContentElementPreviewRenderer;

/***************
 * Add default RTE configuration
 */
//$GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets']['default'] = 'EXT:nc_provider_main/Configuration/RTE/Default.yaml';
//$GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets']['headline'] = 'EXT:nc_provider_main/Configuration/RTE/Headline.yaml';

// https://daniel-siepmann.de/typo3-rte-for-input-fields.html
\TYPO3\CMS\Core\Utility\ArrayUtility::mergeRecursiveWithOverrule(
    $GLOBALS['TYPO3_CONF_VARS'],
    [
        'RTE' => [
            'Presets' => [
                'default' => 'EXT:nc_provider_main/Configuration/RTE/Default.yaml',
            ],
        ],
    ]
);

/***************
 * PageTS
 */
ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:nc_provider_main/Configuration/TsConfig/Page/All.tsconfig">');
ExtensionManagementUtility::addUserTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:nc_provider_main/Configuration/TsConfig/User/config.tsconfig">');

$GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']['de']['EXT:backend/Resources/Private/Language/locallang_layout.xlf'][] = 'EXT:nc_provider_main/Resources/Private/Language/de.cms-backend.locallang_layout.xlf';

// Register Backend PageLayoutHeader
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/db_layout.php']['drawHeaderHook'][] = PageLayoutHeader::class . '->render';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['tt_content_drawItem'][] = ContentElementPreviewRenderer::class;
