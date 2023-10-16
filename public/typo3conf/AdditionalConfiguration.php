<?php
$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['dbname'] = 'typo3_teamspirit';
$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['host'] = '127.0.0.1';
$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['password'] = 'root';
$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['port'] = 3306;
$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['user'] = 'root';

$GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_path'] = '/opt/homebrew/bin/';
$GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_path_lzw'] = '/opt/homebrew/bin/';
$GLOBALS['TYPO3_CONF_VARS']['GFX']['jpg_quality'] = 80;
$GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_stripColorProfileCommand'] = '-strip';

// Enable Development settings
$GLOBALS['TYPO3_CONF_VARS']['FE']['debug'] = '1';
$GLOBALS['TYPO3_CONF_VARS']['BE']['debug'] = '1';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['devIPmask'] = '*';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['displayErrors'] = '1';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['enableDeprecationLog'] = 'file';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['sqlDebug'] = '1';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['systemLogLevel'] = '0';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['exceptionalErrors'] = '28674';

$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport'] = 'smtp';
$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_server'] = '127.0.0.1:1025';
$GLOBALS['TYPO3_CONF_VARS']['EXT']['powermailDevelopContextEmail']='krawietz@new-communication.de';


// Working SSL certificate for development
$GLOBALS['TYPO3_CONF_VARS']['HTTP']['verify'] = false;

// Current Application Context to Site Name
$currentApplicationContext = \TYPO3\CMS\Core\Core\Environment::getContext();
$GLOBALS['TYPO3_CONF_VARS']['SYS']['sitename'] .= ' (' . (string)$currentApplicationContext . ')';
