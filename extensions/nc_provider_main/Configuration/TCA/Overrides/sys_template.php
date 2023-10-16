<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die('Access denied.');
call_user_func(function (): void {
    /**
     * Temporary variables
     */
    $extensionKey = 'nc_provider_main';

    /**
     * Default TypoScript for NcProviderMain
     */
    ExtensionManagementUtility::addStaticFile(
        $extensionKey,
        'Configuration/TypoScript',
        'Nc Provider Main'
    );
});
