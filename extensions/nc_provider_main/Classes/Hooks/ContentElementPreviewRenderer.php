<?php

declare(strict_types=1);

namespace NC\NcProviderMain\Hooks;

/*
 * This file is part of the TYPO3 CMS Extension nc_provider_main.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

use TYPO3\CMS\Backend\View\PageLayoutView;
use TYPO3\CMS\Backend\View\PageLayoutViewDrawItemHookInterface;
use TYPO3\CMS\Core\Resource\FileRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3\CMS\Backend\Utility\BackendUtility;

/**
 * Contains a preview rendering for the page module of all CTypes exclued list
 */
class ContentElementPreviewRenderer implements PageLayoutViewDrawItemHookInterface
{

    /**
     * @param PageLayoutView $parentObject : The parent object that triggered this hook
     * @param bool $drawItem : A switch to tell the parent object, if the item still must be drawn
     * @param string $headerContent : The content of the item header
     * @param string $itemContent : The content of the item itself
     * @param array $row : The current data row for this item
     */
    public function preProcess(
        PageLayoutView &$parentObject,
        &$drawItem,
        &$headerContent,
        &$itemContent,
        array &$row
    ) {
        // array of CType's that should be rendered in the page module
        $cTypes = [
            'accordiongroup',
            'animationtextgroup',
            'blockquotegroup',
            'header',
            'heroteasergroup',
            'highlightpageteaser',
            'icontextgroup',
            'image',
            'imagetxt',
            'imagetextgroup',
            'keyfactgroup',
            'onlytextgroup',
            'pageteaser',
            'revealimage',
            'text',
            'textmedia',
            'uploads',
        ];

        if (in_array($row['CType'], $cTypes)) {
            $standaloneView = $this->getStandAloneConfig();

            /*Disable TYPO3's default backend view configuration */
            $drawItem = false;

            $fileRepository = GeneralUtility::makeInstance(FileRepository::class);

            $row['processedAssets'] = $fileRepository->findByRelation('tt_content', 'assets', $row['uid']);
            $row['processedMedia'] = $fileRepository->findByRelation('tt_content', 'media', $row['uid']);
            $row['processedImage'] = $fileRepository->findByRelation('tt_content', 'image', $row['uid']);

            if ($row['pages']) {
                $row['processedPages'] = $this->generateListForMenuContentTypes($row);
            }

            /*Assign all the results to the backend */
            $standaloneView->assignMultiple([
                'title' => $parentObject->CType_labels[$row['CType']],
                'type' => $row['CType'],
                'content' => $row,
            ]);

            $itemContent .= $standaloneView->render();
        }
    }

    private function generateListForMenuContentTypes(array $row): array
    {
        $uidList = explode(',', $row['pages']);
        $processedPages = [];
        foreach ($uidList as $uid) {
            $uid = (int)$uid;
            $pageRecord = BackendUtility::getRecord('pages', $uid, 'uid,title,hidden');
            if ($pageRecord) {
                $processedPages[] = $pageRecord;
            }
        }
        return $processedPages;
    }

    public function getStandAloneConfig()
    {
        $standaloneView = GeneralUtility::makeInstance(StandaloneView::class);
        $standaloneView->setFormat('html');
        $standaloneView->setLayoutRootPaths([10, 'EXT:nc_provider_main/Resources/Private/Layouts/']);
        $standaloneView->setPartialRootPaths([10, 'EXT:nc_provider_main/Resources/Private/Partials/']);
        $standaloneView->setTemplateRootPaths([10, 'EXT:nc_provider_main/Resources/Private/Templates/Backend/']);
        $standaloneView->setTemplatePathAndFilename('EXT:nc_provider_main/Resources/Private/Templates/Backend/ContentPreview.html');

        return $standaloneView;
    }
}
