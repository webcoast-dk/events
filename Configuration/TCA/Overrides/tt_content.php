<?php

# Main Plugin (List and Details view, Export)
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

ExtensionUtility::registerPlugin(
    'WEBcoast.Events',
    'Main',
    'LLL:EXT:events/Resources/Private/Language/locallang_db.xlf:tx_events.main.title'
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['events_main'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'events_main',
    'FILE:EXT:events/Configuration/FlexForms/Main.xml'
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['events_main'] = 'layout,select_key,recursive';

# Upcoming Plugin (List of upcoming events)
ExtensionUtility::registerPlugin(
    'WEBcoast.Events',
    'Upcoming',
    'LLL:EXT:events/Resources/Private/Language/locallang_db.xlf:tx_events.upcoming.title'
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['events_upcoming'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'events_upcoming',
    'FILE:EXT:events/Configuration/FlexForms/Upcoming.xml'
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['events_upcoming'] = 'layout,select_key,recursive';
