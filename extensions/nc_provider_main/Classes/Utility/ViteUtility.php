<?php

declare(strict_types=1);

/**
 * Copy of https://github.com/crazy252/typo3_vite
 */

namespace NC\NcProviderMain\Utility;

use Exception;
use TYPO3\CMS\Core\Http\RequestFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ViteUtility
{
    /**
     * @param string $extensionPath
     * @param string $configFileName
     * @return string|null
     */
    public static function viteOutPath(string $extensionPath, string $configFileName): ?string
    {
        $configFilePath = $extensionPath . $configFileName;
        $configFileContent = file_get_contents($configFilePath);

        preg_match_all('/outDir:\s?(.+),/m', $configFileContent, $matches, PREG_SET_ORDER);

        if (empty($matches[0][1])) {
            return null;
        }

        return preg_replace('/\/?(\'|")\/?/m', '', $matches[0][1]);
    }

    /**
     * @param string $extension
     * @param string $extensionPath
     * @param string $outPath
     * @param string $srcPath
     * @param string $entry
     * @return array
     */
    public static function viteManifestFile(string $extension, string $extensionPath, string $outPath, string $srcPath, string $entry): array
    {
        $manifestPath = $extensionPath . $outPath . '/.vite/manifest.json';
        if (!file_exists($manifestPath)) {
            return [];
        }

        $outputDir = 'EXT:' . $extension . '/' . $outPath . '/';

        $assets = [];
        foreach (json_decode(file_get_contents($manifestPath)) as $item) {
            if (!is_object($item)) {
                continue;
            }

            if (isset($item->src) && $item->src === $srcPath . '/' . $entry) {
                if (isset($item->css) && is_array($item->css)) {
                    foreach ($item->css as $file) {
                        $assets[] = $outputDir . $file;
                    }
                }

                if (isset($item->file)) {
                    $assets[] = $outputDir . $item->file;
                }
            }
        }

        return $assets;
    }

    /**
     * @param array $settings
     * @return string
     */
    public static function viteDevServerHost(array $settings): string
    {
        $domain = substr(GeneralUtility::getIndpEnv('TYPO3_SITE_URL'), 0, -1);
        if (!empty($settings['domain'])) {
            $domain = $settings['domain'];
        }

        return preg_replace('/\/+$/m', '', $domain) . ':' . ($settings['port'] ?? 3000);
    }

    /**
     * @param array $settings
     * @return bool
     */
    public static function viteDevServerRunning(array $settings): bool
    {
        $requestFactory = GeneralUtility::makeInstance(RequestFactory::class);
        $port = $settings['port'] ?? 3000;

        try {
            $requestFactory->request('https://127.0.0.1:' . $port . '/@vite/client');
        } catch (Exception $e) {
            return false;
        }

        return true;
    }
}
