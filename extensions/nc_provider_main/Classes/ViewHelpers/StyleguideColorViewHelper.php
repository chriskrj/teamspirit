<?php

declare(strict_types=1);

/*
 * Color Styleguide ViewHelper. Returning the Colors from SCSS colors file
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */
namespace NC\NcProviderMain\ViewHelpers;

use Exception;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * StyleguideColorViewHelper
 */
class StyleguideColorViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    /**
     * Initialize arguments.
     *
     * @throws \TYPO3Fluid\Fluid\Core\ViewHelper\Exception
     */
    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('src', 'string', 'a path to a file');
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return string[]
     * @throws \Exception
     */
    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ) {
        $src = (string)$arguments['src'];

        // If no src is given, just an empty string is returned
        if ($src === '') {
            return '';
        }

        // Get the absolute file path
        $absFilePath = GeneralUtility::getFileAbsFileName($src);

        // Verify that the file exists and is readable
        if (!file_exists($absFilePath) || !is_readable($absFilePath)) {
            // File not found or not readable, throw an exception or return an error message
            throw new Exception('File not found or not readable');
        }

        $fileContent = file_get_contents($absFilePath);

        // remove all whitespaces
        $fileContent = preg_replace('/\s+/', '', $fileContent);

        // Remove unwanted characters and split the string into an array
        $arr = explode(';', trim(str_replace('$', '', $fileContent), ';'));

        // Define an empty array to store the objects
        $objArr = array();

        // Loop through each item in the array
        foreach ($arr as $val) {
            // Split the item into key and value
            list($key, $value) = explode(':', $val);
            $objArr[] = (object)['name' => $key, 'hex' => $value];
        }

        return $objArr;

    }
}
