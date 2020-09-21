<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Events',
    'description' => 'Event management for TYPO3 CMS',
    'category' => 'plugin',
    'author' => 'Thorben Nissen',
    'author_email' => 'thorben@webcoast.dk',
    'author_company' => 'WEBcoast',
    'state' => 'stable',
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '1.0.0-dev',
    'constraints' => [
        'depends' => [
            'typo3' => '10.4.0-10.4.99',
            'extbase' => '10.4.0-10.4.99',
            'fluid' => '10.4.0-10.4.99',
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'WEBcoast\\Events\\' => 'Classes',
        ],
    ]
];
