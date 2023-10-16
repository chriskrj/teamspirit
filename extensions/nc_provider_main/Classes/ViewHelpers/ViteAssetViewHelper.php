<?php

declare(strict_types=1);

/**
 * Copy of https://github.com/crazy252/typo3_vite
 */

namespace NC\NcProviderMain\ViewHelpers;

use NC\NcProviderMain\Utility\ViteUtility;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class ViteAssetViewHelper extends AbstractViewHelper
{
    public function initializeArguments(): void
    {
        $this->registerArgument(
            'extension',
            'string',
            'Name of the extension folder name',
            true,
        );
        $this->registerArgument(
            'entry',
            'string',
            'Path to file in the extension folder',
            true,
        );
        $this->registerArgument(
            'config',
            'string',
            'Name of vite config file',
            false,
            'vite.config.js',
        );
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @throws InvalidConfigurationTypeException
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext): void
    {
        $extension = $arguments['extension'];
        $entry = $arguments['entry'];
        $configFileName = $arguments['config'];

        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class);
        $typoScript = $configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT,
            'nc_provider_main'
        );

        $settings = $typoScript['plugin.']['tx_ncprovidermain.']['settings.'] ?? [];

        $extensionPath = ExtensionManagementUtility::extPath($extension);
        $outPath = $settings['out'] ?? ViteUtility::viteOutPath($extensionPath, $configFileName);
        $srcPath = $settings['src'] ?? null;

        $domainWithPort = ViteUtility::viteDevServerHost($settings);
        $viteDevServerRunning = ViteUtility::viteDevServerRunning($settings);
        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);

        if (Environment::getContext()->isDevelopment() && $viteDevServerRunning) {
            $pageRenderer->addJsFile($domainWithPort . '/@vite/client', 'module', false,);
            $pageRenderer->addJsFile($domainWithPort . '/' . $srcPath . '/' . $entry, 'module', false);
        } else if ($outPath and $srcPath) {
            $files = ViteUtility::viteManifestFile($extension, $extensionPath, $outPath, $srcPath, $entry);
            foreach ($files as $file) {
                if (preg_match('/\.js$/', $file)) {
                    $pageRenderer->addJsFooterFile($file, 'module');
                }
                if (preg_match('/\.css$/', $file)) {
                    $pageRenderer->addCssFile($file);
                }
            }
        }
    }
}
