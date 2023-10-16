<?php

/**
 * Extension Manager/Repository config file for ext "nc_provider_main".
 */
$EM_CONF[$_EXTKEY] = [
    'title' => 'Nc Provider Main',
    'description' => '',
    'category' => 'templates',
    'constraints' => [
        'depends' => [
            'typo3' => '11.5.0-11.5.99',
            'fluid_styled_content' => '11.5.0-11.5.99',
            'rte_ckeditor' => '11.5.0-11.5.99',
        ],
        'conflicts' => [
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'NC\\NcProviderMain\\' => 'Classes',
        ],
    ],
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 1,
    'author' => 'Christopher Krawietz',
    'author_email' => 'chriskrawietz@gmail.com',
    'author_company' => 'Skybox',
    'version' => '1.0.0',
];
