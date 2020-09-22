<?php

$llPrefix = 'LLL:EXT:events/Resources/Private/Language/locallang_db.xlf:tx_events_domain_model_event';

return [
    'ctrl' => [
        'title' => $llPrefix,
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
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
        'searchFields' => 'title,teaser,description,location'
    ],
    'types' => [
        '1' => [
            'showitem' => 'title,teaser,description,location,organizer,--palette--;;times,images,downloads,--div--;LLL:EXT:events/Resources/Private/Language/locallang_db.xlf:tx_events_domain_model_event.recurring,recurring_weeks,recurring_days,recurring_stop,recurring_exclude_holidays,recurring_exclude_dates,--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,--palette--;;language,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xml:tabs.access,--palette--;;access',
        ],
    ],
    'palettes' => [
        'times' => [
            'showitem' => 'date, time, --linebreak--, end_date, end_time, --linebreak--, non_stop'
        ],
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
                'default' => 0,
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
                'foreign_table' => 'tx_events_domain_model_event',
                'foreign_table_where' => 'AND tx_events_domain_model_event.pid=###CURRENT_PID### AND tx_events_domain_model_event.sys_language_uid IN (-1,0)',
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
        'title' => [
            'exclude' => 0,
            'label' => $llPrefix . '.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required',
            ],
        ],
        'teaser' => [
            'exclude' => 0,
            'label' => $llPrefix . '.teaser',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 5,
                'eval' => 'trim',
            ],
        ],
        'description' => [
            'exclude' => 0,
            'label' => $llPrefix . '.description',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim,required',
                'enableRichtext' => true,
            ],
        ],
        'location' => [
            'exclude' => 0,
            'label' => $llPrefix . '.location',
            'config' => [
                'type' => 'text',
                'cols' => 30,
                'rows' => 5,
                'eval' => 'trim',
            ],
        ],
        'organizer' => [
            'exclude' => 1,
            'label' => $llPrefix . '.organizer',
            'l10n_mode' => 'exclude',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_events_domain_model_organizer',
                'foreign_table' => 'tx_events_domain_model_organizer',
                'MM' => 'tx_events_domain_model_event_2_organizer',
                'size' => 5,
                'autoSizeMax' => 20,
                'fieldControl' => [
                    'addRecord' => [
                        'disabled' => false,
                        'after' => [
                            'elementBrowser'
                        ]
                    ],
                    'editPopup' => [
                        'disabled' => false,
                        'after' => [
                            'addRecord'
                        ]
                    ]
                ]
            ]
        ],
        'date' => [
            'exclude' => 0,
            'label' => $llPrefix . '.date',
            'l10n_mode' => 'exclude',
            'config' => [
                'type' => 'input',
                'dbType' => 'date',
                'renderType' => 'inputDateTime',
                'size' => 12,
                'eval' => 'date,required',
                'checkbox' => 1,
            ],
        ],
        'time' => [
            'exclude' => 0,
            'label' => $llPrefix . '.time',
            'l10n_mode' => 'exclude',
            'config' => [
                'type' => 'input',
                'dbType' => 'time',
                'size' => 10,
                'eval' => 'time',
            ],
        ],
        'end_date' => [
            'exclude' => 0,
            'label' => $llPrefix . '.end_date',
            'l10n_mode' => 'exclude',
            'config' => [
                'type' => 'input',
                'dbType' => 'date',
                'renderType' => 'inputDateTime',
                'size' => 12,
                'eval' => 'date',
                'checkbox' => 1,
            ],
        ],
        'end_time' => [
            'exclude' => 0,
            'label' => $llPrefix . '.end_time',
            'l10n_mode' => 'exclude',
            'config' => [
                'type' => 'input',
                'dbType' => 'time',
                'size' => 10,
                'eval' => 'time',
            ],
        ],
        'non_stop' => [
            'exclude' => 1,
            'label' => $llPrefix . '.non_stop',
            'l10n_mode' => 'exclude',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    ['', '', 'invertStateDisplay' => true]
                ]
            ],
        ],
        'recurring_weeks' => [
            'exclude' => 0,
            'label' => $llPrefix . '.recurring_weeks',
            'l10n_mode' => 'exclude',
            'config' => [
                'type' => 'check',
                'items' => [
                    [
                        $llPrefix . '.recurring_weeks.0',
                        '',
                    ],
                    [
                        $llPrefix . '.recurring_weeks.1',
                        '',
                    ],
                    [
                        $llPrefix . '.recurring_weeks.2',
                        '',
                    ],
                    [
                        $llPrefix . '.recurring_weeks.3',
                        '',
                    ],
                    [
                        $llPrefix . '.recurring_weeks.4',
                        '',
                    ],
                    [
                        $llPrefix . '.recurring_weeks.5',
                        '',
                    ],
                ],
                'suppress_icons' => 1,
            ],
        ],
        'recurring_days' => [
            'exclude' => 0,
            'label' => $llPrefix . '.recurring_days',
            'l10n_mode' => 'exclude',
            'config' => [
                'type' => 'check',
                'items' => [
                    [
                        $llPrefix . '.recurring_days.0',
                        '',
                    ],
                    [
                        $llPrefix . '.recurring_days.1',
                        '',
                    ],
                    [
                        $llPrefix . '.recurring_days.2',
                        '',
                    ],
                    [
                        $llPrefix . '.recurring_days.3',
                        '',
                    ],
                    [
                        $llPrefix . '.recurring_days.4',
                        '',
                    ],
                    [
                        $llPrefix . '.recurring_days.5',
                        '',
                    ],
                    [
                        $llPrefix . '.recurring_days.6',
                        '',
                    ],
                ],
                'suppress_icons' => 1,
            ],
        ],
        'recurring_stop' => [
            'exclude' => 0,
            'label' => $llPrefix . '.recurring_stop',
            'l10n_mode' => 'exclude',
            'config' => [
                'type' => 'input',
                'dbType' => 'date',
                'renderType' => 'inputDateTime',
                'size' => 12,
                'eval' => 'date',
                'checkbox' => 1,
            ],
        ],
        'recurring_exclude_holidays' => [
            'exclude' => 0,
            'label' => $llPrefix . '.recurring_exclude_holidays',
            'l10n_mode' => 'exclude',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'default' => 0,
            ],
        ],
        'recurring_exclude_dates' => [
            'exclude' => 0,
            'label' => $llPrefix . '.recurring_exclude_dates',
            'l10n_mode' => 'exclude',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
            ],
        ],
        'images' => [
            'exclude' => 0,
            'label' => $llPrefix . '.images',
            'config' => TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('images',
                [
                    'appearance' => [
                        'createNewRelationLinkTitle' => $llPrefix . '.images.add',
                        'fileUploadAllowed' => false
                    ],
                    'behaviour' => [
                        'allowLanguageSynchronization' => true
                    ]
                ],
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']),
        ],
        'downloads' => [
            'exclude' => 0,
            'label' => $llPrefix . '.downloads',
            'config' => TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('downloads',
                [
                    'appearance' => [
                        'createNewRelationLinkTitle' => $llPrefix . '.downloads.add',
                        'fileUploadAllowed' => false
                    ],
                    'behaviour' => [
                        'allowLanguageSynchronization' => true
                    ]
                ]
            ),
        ],
    ],
];
