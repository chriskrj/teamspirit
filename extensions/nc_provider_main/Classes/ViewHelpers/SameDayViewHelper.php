<?php

declare(strict_types=1);

namespace NC\NcProviderMain\ViewHelpers;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * A view helper for checking if two days are the same day
 *
 * = Examples =
 *
 * xmlns:nc="http://typo3.org/ns/NC/NcProviderMain/ViewHelpers"
 *
 * <code>
 * {nc:sameDay(endDate: event.enddate, startDate: event.startdate)}
 * </code>
 * <output>
 * true or false
 * </output>
 */
class SameDayViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    /**
     * Initialize arguments
     */
    public function initializeArguments(): void
    {
        $this->registerArgument('startDate', 'dateTime', 'Start Date', true);
        $this->registerArgument('endDate', 'dateTime', 'End Date', true);
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return bool sameDay
     */
    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ): bool {
        $startDate = $arguments['startDate'];
        $endDate = $arguments['endDate'];

        if (is_a($startDate, \DateTime::class) && is_a($endDate, \DateTime::class)) {
            return $startDate->format('d.m.Y') === $endDate->format('d.m.Y');
        }
        return false;
    }
}
