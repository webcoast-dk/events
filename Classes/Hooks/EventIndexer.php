<?php
namespace WEBcoast\Events\Hooks;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012-2015 Morton Jonuschat <m.jonuschat@gute-botschafter.de>, Gute Botschafter GmbH
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use TYPO3\CMS\Backend\Form\FormEngine;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\ArrayUtility;

class EventIndexer
{
    /**
     * Pages to index
     *
     * @var array
     */
    protected $indexPids = '';
    /**
     * Array containing data of all pages
     *
     * @var array
     */
    protected $pageRecords;
    /**
     * Status information for user
     *
     * @var string
     */
    protected $content = '';
    /**
     * The indexer object
     *
     * @var \tx_kesearch_indexer
     */
    protected $indexerObject;
    /**
     * The indexer configuration
     *
     * @var array
     */
    protected $indexerConfig;
    /**
     * Indexed events
     *
     * @var integer
     */
    protected $eventCount = 0;

    /**
     * Register the indexer configuration
     *
     * @param array $params
     * @param object $pObj
     */
    public function registerIndexerConfiguration(
        &$params,
        /** @noinspection PhpUnusedParameterInspection */
        $pObj
    ) {
        // add item to "type" field
        $params['items'][] = [
            'LLL:EXT:events/Resources/Private/Language/locallang_db.xml:tx_events_kesearch_event.indexer_name',
            'events_event',
            'EXT:events/Resources/Public/Icons/selicon_indexer_events_event.gif',
        ];
        $GLOBALS['TCA']['tx_kesearch_indexerconfig']['columns']['target_pid']['displayCond'] .= ',events_event';
        $GLOBALS['TCA']['tx_kesearch_indexerconfig']['columns']['sysfolder']['displayCond'] .= ',events_event';
    }

    /**
     * Custom index for ke_search to index content provided
     * by the extension events
     *
     * @param array $indexerConfig
     * @param \tx_kesearch_indexer $indexerObject
     * @return bool|string
     */
    public function customIndexer(&$indexerConfig, \tx_kesearch_indexer &$indexerObject)
    {
        $this->indexerConfig = $indexerConfig;
        $this->indexerObject = $indexerObject;
        $this->content = '';

        // bail out if we are passed a config that is not of our type
        if ($indexerConfig['type'] !== 'events_event') {
            return false;
        }

        foreach (ArrayUtility::trimExplode(',', $this->indexerConfig['sysfolder'], true) as $pid) {
            $this->indexEvents($pid);
        }
        $this->content .= '<p><b>Indexer "'
            . $this->indexerConfig['title']
            . '": '
            . $this->eventCount
            . ' events have been indexed.</b></p>'
            . "\n";

        return $this->content;
    }

    /**
     * Join all fields to make up the content auf the event record
     * This is the text information that will be indexed
     *
     * @param  array $event
     * @return string $content
     */
    protected function renderEventContent($event)
    {
        $content = [
            $event['title'],
            $event['location'],
        ];

        return trim(join("\n", array_filter($content)));
    }

    /**
     * Process all title/book records for a given page id
     *
     * @param int $pageId
     */
    protected function indexEvents($pageId)
    {
        $events = $this->getDatabaseConnection()->exec_SELECTquery(
            'uid, pid, tstamp, title, location',
            'tx_events_domain_model_event',
            'pid = ' . $pageId,
            '',
            ''
        );

        while ($event = $this->getDatabaseConnection()->sql_fetch_assoc($events)) {
            $indexTitle = $event['title'];
            $abstract = $event['title'] . "\n" . $event['location'];
            $fullContent = $this->renderEventContent($event);
            $tagContent = '';

            $params = [
                'tx_events_main[action]' => 'show',
                'tx_events_main[controller]' => 'Event',
                'tx_events_main[event]' => $event['uid'],
            ];

            // Additional fields for the indexer
            $additionalFields = [
                'sortdate' => $event['tstamp'],
                'orig_uid' => $event['uid'],
                'orig_pid' => $event['pid'],
            ];

            // Honor hooks to modify the indexed data
            if (is_array($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ke_search']['modifyEventIndexEntry'])) {
                foreach ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ke_search']['modifyEventIndexEntry'] as $_classRef) {
                    $_procObj = &GeneralUtility::getUserObj($_classRef);
                    $_procObj->modifyEventIndexEntry(
                        $indexTitle,
                        $abstract,
                        $fullContent,
                        $params,
                        $tagContent,
                        $event,
                        $additionalFields
                    );
                }
            }

            // Store the record in the index
            $this->indexerObject->storeInIndex(
                $this->indexerConfig['storagepid'],
                $indexTitle,
                'events_event',
                $this->indexerConfig['targetpid'],
                $fullContent,
                $tagContent,
                '&' . http_build_query($params),
                $abstract,
                $sys_language_uid = 0,
                $starttime = 0,
                $endtime = 0,
                $feGroup = 0,
                $debug = false,
                $additionalFields
            );

            $this->eventCount++;
        }
    }

    /**
     * @return \TYPO3\CMS\Core\Database\DatabaseConnection;
     */
    protected function getDatabaseConnection()
    {
        return $GLOBALS['TYPO3_DB'];
    }
}
