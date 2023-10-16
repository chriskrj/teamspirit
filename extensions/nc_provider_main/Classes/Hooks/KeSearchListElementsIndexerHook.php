<?php

declare(strict_types=1);

namespace NC\NcProviderMain\Hooks;

use Doctrine\DBAL\Driver\Exception;
use Tpwd\KeSearch\Indexer\Types\Page;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Database\Query\Restriction\HiddenRestriction;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class KeSearchListElementsIndexerHook
{
    public function modifyPageContentFields(&$fields, $pageIndexer): void
    {
        $fields .= ',tx_listelements_list';
    }

    /**
     * @param string $bodytext
     * @param array $ttContentRow
     * @param Page $pageIndexer
     * @throws Exception
     */
    public function modifyContentFromContentElement(string &$bodytext, array $ttContentRow, Page $pageIndexer): void
    {
        if ($ttContentRow['tx_listelements_list'] > 0) {
            $listElements = $this->getListElementContent($ttContentRow['uid']);
            foreach ($listElements as $listElement) {
                $bodytext .= trim(strip_tags("\n " . $listElement['subheader'] . "\n " . $listElement['header'] . "\n " . $listElement['text'] . "\n " . $listElement['bodytext'] . "\n "));
            }
        }
    }

    /**
     * @throws \Exception|Exception
     */
    protected function getListElementContent(int $contentUid): array
    {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tx_listelements_item');

        $queryBuilder->getRestrictions()
            ->add(GeneralUtility::makeInstance(DeletedRestriction::class))
            ->add(GeneralUtility::makeInstance(HiddenRestriction::class));

        return $queryBuilder
            ->select('*')
            ->from('tx_listelements_item')
            ->where(
                $queryBuilder->expr()->eq('tablename', $queryBuilder->createNamedParameter('tt_content')),
                $queryBuilder->expr()->eq('uid_foreign', $queryBuilder->createNamedParameter($contentUid, \PDO::PARAM_INT)),
            )
            ->execute()
            ->fetchAllAssociative();
    }
}
