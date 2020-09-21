<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
    'tx_events_domain_model_event',
    'EXT:events/Resources/Private/Language/locallang_csh_tx_events_domain_model_event.xlf'
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_events_domain_model_event');
