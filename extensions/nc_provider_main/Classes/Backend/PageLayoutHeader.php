<?php

declare(strict_types=1);

namespace NC\NcProviderMain\Backend;

use TYPO3\CMS\Backend\Controller\PageLayoutController;
use TYPO3\CMS\Core\Resource\FileRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

class PageLayoutHeader
{
    protected StandaloneView $view;

    public function render(array $params, PageLayoutController $parentObject): string
    {
        $pageinfo = $parentObject->pageinfo;

        $fileRepository = GeneralUtility::makeInstance(FileRepository::class);
        $fileObjects = $fileRepository->findByRelation('pages', 'media', $pageinfo['uid']);
        $iconObjects = $fileRepository->findByRelation('pages', 'icon', $pageinfo['uid']);

        //load partial paths info from typoscript
        $standaloneView = GeneralUtility::makeInstance(StandaloneView::class);
        $standaloneView->setTemplatePathAndFilename(
            GeneralUtility::getFileAbsFileName(
                'EXT:nc_provider_main/Resources/Private/Templates/Backend/PageLayoutHeader.html'
            )
        );

        $standaloneView->assign('files', $fileObjects);
        $standaloneView->assign('icons', $iconObjects);
        $standaloneView->assign('page', $parentObject->pageinfo);

        return $standaloneView->render();
    }
}
