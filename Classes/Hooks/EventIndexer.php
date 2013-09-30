<?php
require_once t3lib_extMgm::extPath('gb_events') . 'Classes/Hooks/KeSearchIndexer.php';

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012-2013 Morton Jonuschat <m.jonuschat@gute-botschafter.de>, Gute Botschafter GmbH
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


/**
 *
 * @package gb_events
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 *
 */

class user_gbevents_kesearch_event extends gb_events_kesearch_indexer {
  /**
   * Indexed events
   * @var integer
   */
  protected $eventCount = 0;

  /**
   * Custom index for ke_search to index content provided
   * by the extension gb_events
   *
   * @param   array $indexerConfig
   * @param   array $indexerObject
   * @return  string $output
   * @author  Morton Jonuschat <mj@gute-botschafter.de>
   */
  public function customIndexer(&$indexerConfig, &$indexerObject) {
    parent::customIndexer($indexerConfig, $indexerObject);

    # bail out if we are passed a config that is not of our type
    if($indexerConfig['type'] !== 'gbevents_event') {
      return FALSE;
    }

    foreach(t3lib_div::trimExplode(',', $this->indexerConfig['sysfolder'], true) as $pid) {
      $this->indexEvents($pid);
    }
    $this->content .= '<p><b>Indexer "' . $this->indexerConfig['title'] . '": ' . $this->eventCount . ' events have been indexed.</b></p>' . "\n";

    return $this->content;
  }

  /**
   * Join all fields to make up the content auf the event record
   * This is the text information that will be indexed
   *
   * @param array $event
   * @return string $content
   */
  protected function renderEventContent($event) {
    $content = array(
      $event['title'],
      $event['location'],
    );

    return trim(join("\n", array_filter($content)));
  }

  /**
   * Process all title/book records for a given page id
   *
   * @param integer $pageId
   * @return void
   */
  protected function indexEvents($pageId) {
    $events = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
      'uid, pid, tstamp, title, location',
      'tx_gbevents_domain_model_event',
      'pid = ' . $pageId,
      '',
      ''
    );

    while($event = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($events)) {
      $indexTitle = $event['title'];
      $abstract = $event['title'] . "\n" . $event['location'];
      $fullContent = $this->renderEventContent($event);
      $tagContent = $this->pageTags[intval($this->indexerConfig['sysfolder'])]['tags'];

      $params = array(
        'tx_gbevents_main[action]' => 'show',
        'tx_gbevents_main[controller]' => 'Event',
        'tx_gbevents_main[event]' => $event['uid'],
      );

      # Additional fields for the indexer
      $additionalFields = array(
        'sortdate' => $event['tstamp'],
        'orig_uid' => $event['uid'],
        'orig_pid' => $event['pid'],
      );

      # Honor hooks to modify the indexed data
      if (is_array($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ke_search']['modifyEventIndexEntry'])) {
        foreach($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ke_search']['modifyEventIndexEntry'] as $_classRef) {
          $_procObj = & t3lib_div::getUserObj($_classRef);
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

      # Store the record in the index
      $this->indexerObject->storeInIndex(
        $this->indexerConfig['storagepid'],
        $indexTitle,
        'gbevents_event',
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
}