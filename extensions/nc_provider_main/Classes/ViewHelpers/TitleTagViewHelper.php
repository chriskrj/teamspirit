<?php

declare(strict_types=1);

namespace NC\NcProviderMain\ViewHelpers;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * ### ViewHelper used to override page title
 */
class TitleTagViewHelper extends AbstractViewHelper
{

    /**
     * Arguments initialization
     */
    public function initializeArguments(): void
    {
        $this->registerArgument('title', 'string', 'Title tag content');
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext): void
    {
        if (false === empty($arguments['title'])) {
            $title = $arguments['title'];
        } else {
            $title = $renderChildrenClosure();
        }

        $titleProvider = GeneralUtility::makeInstance(\NC\NcProviderMain\PageTitle\ExtensionPageTitleProvider::class);
        $titleProvider->setTitle($title);
    }
}
