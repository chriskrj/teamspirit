<?php

declare(strict_types=1);
/**
 * User: christiansen
 * Date: 2019-01-04
 * Time: 17:26
 */

namespace NC\NcProviderMain\ViewHelpers;

use TYPO3\CMS\Core\LinkHandling\LinkService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * A view helper for rendering the linktype
 *
 * = Examples =
 *
 * <code>
 * {nc:linkType(parameter: settings.link)}
 * </code>
 * <output>
 * page, file, url, email, folder, unknown
 * </output>
 */
class LinkTypeViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    /**
     * Initialize arguments
     */
    public function initializeArguments(): void
    {
        $this->registerArgument('parameter', 'string', 'stdWrap.typolink style parameter string', true);
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return string Linktype (page, file, url, email, folder, unknown)
     */
    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ): string {
        // workaround if parameter has _blank or other additional params
        $parameter = $arguments['parameter'];
        $arr = explode(' ', trim($parameter));
        $firstparameter = $arr[0];

        $linkService = GeneralUtility::makeInstance(LinkService::class);
        $linkDetails = $linkService->resolve($firstparameter);

        return $linkDetails['type'];
    }
}
