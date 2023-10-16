<?php

declare(strict_types=1);

/*
 * /*
 * Copy of bootstrap_package InlineSvgViewHelper
 * https://github.com/benjaminkott/bootstrap_package/blob/master/Classes/ViewHelpers/InlineSvgViewHelper.php
 *
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace NC\NcProviderMain\ViewHelpers;

use NC\NcProviderMain\Utility\SvgUtility;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * InlineSvgViewHelper
 */
class InlineSvgViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    /**
     * @var bool
     */
    protected $escapeOutput = false;

    /**
     * Initialize arguments.
     *
     * @throws \TYPO3Fluid\Fluid\Core\ViewHelper\Exception
     */
    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('image', 'object', 'a FAL object');
        $this->registerArgument('src', 'string', 'a path to a file');
        $this->registerArgument('class', 'string', 'Css class for the svg');
        $this->registerArgument('width', 'string', 'Width of the svg.', false);
        $this->registerArgument('height', 'string', 'Height of the svg.', false);
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return string
     * @throws \Exception
     */
    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ) {
        $src = (string)$arguments['src'];
        $image = $arguments['image'];
        $width = $arguments['width'] ? (int)$arguments['width'] : null;
        $height = $arguments['height'] ? (int)$arguments['height'] : null;
        $class = $arguments['class'] ? (string)$arguments['class'] : null;

        // If no image or src is given, just an empty string is returned
        if ($src === '' and $image === null) {
            return '';
        }

        return SvgUtility::getInlineSvg($src, $image, $width, $height, $class);
    }
}
