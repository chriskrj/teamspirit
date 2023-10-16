<?php

declare(strict_types=1);

/**
 * User: christiansen
 * Date: 2019-09-12
 * Time: 17:26
 */
namespace NC\NcProviderMain\ViewHelpers;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * A view helper for rendering the YouTube Id from an url
 *
 * = Examples =
 *
 * <code>
 * {nc:youTubeId(url: 'https://www.youtube.com/watch?v=zpOVYePk6mM')}
 * </code>
 * <output>
 * zpOVYePk6mM
 * </output>
 */
class YouTubeIdViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    /**
     * Initialize arguments
     */
    public function initializeArguments(): void
    {
        $this->registerArgument('url', 'string', 'YouTube url', true);
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return string youtube id
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $url = $arguments['url'];
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
        return $match[1];
    }
}
