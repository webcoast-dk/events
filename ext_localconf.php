<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'WEBcoast.Events',
    'Main',
    [
        'Event' => 'list, show',
        'Archive' => 'list',
        'Calendar' => 'show',
        'Export' => 'list, show',
    ]
);

TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'WEBcoast.Events',
    'Upcoming',
    [
        'Upcoming' => 'list',
    ]
);

$iconRegistry = TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(TYPO3\CMS\Core\Imaging\IconRegistry::class);
$iconRegistry->registerIcon(
    'ext-events-plugin',
    TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
    ['source' => 'EXT:events/ext_icon.gif']
);
