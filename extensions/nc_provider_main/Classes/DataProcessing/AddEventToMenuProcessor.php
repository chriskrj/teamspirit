<?php

declare(strict_types=1);

namespace NC\NcProviderMain\DataProcessing;

use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Context\Exception\AspectNotFoundException;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * This file is part of the "nc_provider_main" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

/**
 * Add the current event record to any menu, e.g. breadcrumb
 *
 * 20 = NC\NcProviderMain\DataProcessing\AddEventToMenuProcessor
 * 20.menus = breadcrumbMenu,specialMenu
 */
class AddEventToMenuProcessor implements DataProcessorInterface
{
    /**
     * @param ContentObjectRenderer $cObj
     * @param array $contentObjectConfiguration
     * @param array $processorConfiguration
     * @param array $processedData
     * @return array
     */
    public function process(ContentObjectRenderer $cObj, array $contentObjectConfiguration, array $processorConfiguration, array $processedData): array
    {
        if (!$processorConfiguration['menus']) {
            return $processedData;
        }
        $eventRecord = $this->getEventRecord();
        if ($eventRecord) {
            $menus = GeneralUtility::trimExplode(',', $processorConfiguration['menus'], true);
            foreach ($menus as $menu) {
                if (isset($processedData[$menu])) {
                    $this->addEventRecordToMenu($eventRecord, $processedData[$menu]);
                }
            }
        }
        return $processedData;
    }

    /**
     * Add the event record to the menu items
     *
     * @param array $eventRecord
     * @param array $menu
     *
     * @return void
     */
    protected function addEventRecordToMenu(array $eventRecord, array &$menu): void
    {
        foreach ($menu as &$menuItem) {
            $menuItem['current'] = 0;
        }

        $menu[] = [
            'data' => $eventRecord,
            'title' => $eventRecord['title'],
            'active' => 1,
            'current' => 1,
            'link' => GeneralUtility::getIndpEnv('TYPO3_REQUEST_URL'),
            'isEvent' => true
        ];
    }

    /**
     * Get the event record including possible translations
     *
     * @return array
     */
    protected function getEventRecord(): array
    {
        $eventId = 0;

        $eventDetailVars = GeneralUtility::_GET('tx_sfeventmgt_pieventdetail');
        $eventRegistrationVars = GeneralUtility::_GET('tx_sfeventmgt_pieventregistration');

        if (isset($eventDetailVars['event'])) {
            $eventId = (int)$eventDetailVars['event'];
        } elseif (isset($eventRegistrationVars['event'])) {
            $eventId = (int)$eventRegistrationVars['event'];
        }

        if ($eventId) {
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
                ->getQueryBuilderForTable('tx_event_domain_model_event');
            $row = $queryBuilder
                ->select('*')
                ->from('tx_sfeventmgt_domain_model_event')
                ->where(
                    $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($eventId, \PDO::PARAM_INT))
                )
                ->execute()
                ->fetch();

            if ($row) {
                $row = $this->getTsfe()->sys_page->getRecordOverlay('tx_sfeventmgt_domain_model_event', $row, $this->getCurrentLanguage());
            }

            if (is_array($row) && !empty($row)) {
                return $row;
            }
        }
        return [];
    }

    /**
     * Get current language
     *
     * @return int
     */
    protected function getCurrentLanguage(): int
    {
        $languageId = 0;
        $context = GeneralUtility::makeInstance(Context::class);
        try {
            $languageId = $context->getPropertyFromAspect('language', 'contentId');
        } catch (AspectNotFoundException $e) {
            // do nothing
        }

        return (int)$languageId;
    }

    /**
     * @return TypoScriptFrontendController
     */
    protected function getTsfe(): TypoScriptFrontendController
    {
        return $GLOBALS['TSFE'];
    }
}
