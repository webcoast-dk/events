<?php

$llPrefix = 'LLL:EXT:events/Resources/Private/Language/locallang_db.xlf:tx_events_domain_model_organizer';

return [
    'ctrl' => [
        'title' => $llPrefix,
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'default_sortby' => 'name asc',
        'versioningWS' => true,
        'origUid' => 'l10n_original',
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'iconfile' => 'EXT:events/Resources/Public/Icons/tx_events_domain_model_event.gif',
        'searchFields' => 'name,address,email,website'
    ],
    'types' => [
        '1' => [
            'showitem' => 'name,address,email,phone,website,--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,--palette--;;language,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xml:tabs.access,--palette--;;access',
        ],
    ],
    'palettes' => [
        'access' => [
            'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access',
            'showitem' => 'hidden, starttime;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:starttime_formlabel, endtime;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:endtime_formlabel, --linebreak--, fe_group;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:fe_group_formlabel'
        ],
        'language' => [
            'showitem' => 'sys_language_uid;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:sys_language_uid_formlabel,l18n_parent'
        ]
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'default' => -1,
                'items' => [
                    [
                        'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.allLanguages',
                        -1,
                        'flags-multiple'
                    ],
                ],
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => 1,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_events_domain_model_organizer',
                'foreign_table_where' => 'AND tx_events_domain_model_organizer.pid=###CURRENT_PID### AND tx_events_domain_model_organizer.sys_language_uid IN (-1,0)',
                'default' => 0,
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'hidden' => [
            'exclude' => 1,
            'label' => $llPrefix . '.hidden',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    ['', '', 'invertStateDisplay' => true]
                ]
            ],
        ],
        'starttime' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'l10n_mode' => 'exclude',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => '10',
                'eval' => 'datetime',
                'checkbox' => '0',
                'default' => '0',
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'endtime' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'l10n_mode' => 'exclude',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => '8',
                'eval' => 'datetime',
                'checkbox' => '0',
                'default' => '0',
                'range' => [
                    'upper' => mktime(0, 0, 0, 12, 31, date('Y') + 10),
                    'lower' => mktime(0, 0, 0, date('m') - 1, date('d'), date('Y')),
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'name' => [
            'exclude' => 0,
            'label' => $llPrefix . '.name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required',
            ],
        ],
        'address' => [
            'exclude' => 1,
            'label' => $llPrefix . '.address',
            'config' => [
                'type' => 'text',
                'cols' => 20,
                'rows' => 5,
                'eval' => 'trim',
            ],
        ],
        'phone' => [
            'exclude' => 1,
            'label' => $llPrefix . '.phone',
            'config' => [
                'type' => 'input',
                'eval' => 'trim'
            ],
        ],
        'email' => [
            'exclude' => 1,
            'label' => $llPrefix . '.email',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,email',
            ],
        ],
        'website' => [
            'exclude' => 1,
            'label' => $llPrefix . '.website',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputLink',
                'size' => 30,
            ]
        ]
    ],
];
