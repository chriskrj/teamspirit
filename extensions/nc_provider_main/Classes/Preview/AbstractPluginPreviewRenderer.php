<?php

declare(strict_types=1);

namespace NC\NcProviderMain\Preview;

use TYPO3\CMS\Backend\Preview\PreviewRendererInterface;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Backend\Utility\BackendUtility as BackendUtilityCore;
use TYPO3\CMS\Backend\View\BackendLayout\Grid\GridColumnItem;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

abstract class AbstractPluginPreviewRenderer implements PreviewRendererInterface
{
    protected string $lll = '';

    /**
     * @var IconFactory
     */
    protected IconFactory $iconFactory;

    public function __construct()
    {
        $this->iconFactory = GeneralUtility::makeInstance(IconFactory::class);
    }

    public function renderPageModulePreviewHeader(GridColumnItem $item): string
    {
        $record = $item->getRecord();
        $label = BackendUtility::getLabelFromItemListMerged($record['pid'], 'tt_content', 'list_type', $record['list_type']);
        return '<strong>' . htmlspecialchars($this->getLanguageService()->sL($label)) . '</strong> <br/>';
    }

    public function renderPageModulePreviewContent(GridColumnItem $item): string
    {
        // Must be overwritten in extending class!
        return '';
    }

    public function renderPageModulePreviewFooter(GridColumnItem $item): string
    {
        // Can be overwritten in extending class if required
        return '';
    }

    public function wrapPageModulePreview(string $previewHeader, string $previewContent, GridColumnItem $item): string
    {
        return $previewHeader . $previewContent;
    }

    /**
     * Renders the given data as table for plugin preview
     *
     * @param array $data
     * @return string
     */
    protected function renderAsTable(array $data): string
    {
        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $pageRenderer->addCssFile('EXT:nc_provider_main/Resources/Public/Css/Backend/PluginPreview.css');

        $view = GeneralUtility::makeInstance(StandaloneView::class);
        $view->setTemplatePathAndFilename(
            GeneralUtility::getFileAbsFileName('EXT:nc_provider_main/Resources/Private/Templates/Backend/PluginPreview.html')
        );
        $view->assignMultiple([
            'data' => $data
        ]);

        return $view->render();
    }

    /**
     * Returns which records of the given field fields are selected
     *
     * @param array $contentRecord
     * @param string $title
     * @param string $field
     * @param string $flexFormSheet
     * @param string $table
     * @return array
     */
    protected function getSelectedRecords(
        array $contentRecord,
        string $title,
        string $field,
        string $flexFormSheet = 'sDEF',
        string $table = 'pages'
    ): array {
        $flexFormData = GeneralUtility::xml2array($contentRecord['pi_flexform']);

        $data = [];
        $value = $this->getFieldFromFlexform($flexFormData, $field, $flexFormSheet);

        if (!empty($value)) {
            $recordUids = GeneralUtility::intExplode(',', $value, true);
            $recordsOutput = [];

            foreach ($recordUids as $id) {
                $recordsOutput[] = $this->getRecordData($id, $table);
            }

            $data = [
                'title' => $this->getLanguageService()->sL($this->lll . $title),
                'value' => implode(', ', $recordsOutput)
            ];
        }

        return $data;
    }

    /**
     * Returns the selected value of a single select field
     *
     * @param array $contentRecord
     * @param string $title
     * @param string $field
     * @param string $flexFormSheet
     * @return array
     */
    protected function getSelectSingleFieldValue(
        array $contentRecord,
        string $title,
        string $field,
        string $flexFormSheet = 'sDEF'
    ): array {
        $flexFormData = GeneralUtility::xml2array($contentRecord['pi_flexform']);

        $data = [];
        $value = $this->getFieldFromFlexform($flexFormData, $field, $flexFormSheet);

        if (!empty($value)) {
            if ((int)$value === -1) {
                $value = 'all';
            }

            $data = [
                'title' => $this->getLanguageService()->sL($this->lll . $title),
                'value' => $this->getLanguageService()->sL($this->lll . $title . '.' . $value),
            ];
        }

        return $data;
    }

    /**
     * Returns if a given checkbox field is selected
     */
    protected function getCheckFieldValue(
        array $contentRecord,
        string $title,
        string $field,
        string $flexFormSheet = 'sDEF'
    ): array {
        $flexFormData = GeneralUtility::xml2array($contentRecord['pi_flexform']);

        $data = [];
        $value = $this->getFieldFromFlexform($flexFormData, $field, $flexFormSheet);

        if ($value === '1') {
            $data = [
                'title' => $this->getLanguageService()->sL($this->lll . $title),
                'value' => '<i class="fa fa-check"></i>',
            ];
        }

        return $data;
    }

    /**
     * Returns if a given input field is selected
     */
    protected function getInputFieldValue(
        array $contentRecord,
        string $title,
        string $field,
        string $flexFormSheet = 'sDEF'
    ): array {
        $flexFormData = GeneralUtility::xml2array($contentRecord['pi_flexform']);

        $data = [];
        $value = $this->getFieldFromFlexform($flexFormData, $field, $flexFormSheet);

        if ($value !== '') {
            $data = [
                'title' => $this->getLanguageService()->sL($this->lll . $title),
                'value' => $value,
            ];
        }

        return $data;
    }

    /**
     * Returns the record data item
     *
     * @param int $id
     * @param string $table
     * @return string
     */
    protected function getRecordData(int $id, string $table = 'pages'): string
    {
        $content = '';
        $record = BackendUtilityCore::getRecord($table, $id);

        if (is_array($record)) {
            $data = '<span data-toggle="tooltip" data-placement="top" data-title="id=' . $record['uid'] . '">'
                . $this->iconFactory->getIconForRecord($table, $record, Icon::SIZE_SMALL)->render()
                . '</span> ';
            $content = BackendUtilityCore::wrapClickMenuOnIcon($data, $table, $record['uid'], true, '', '+info');

            $linkTitle = htmlspecialchars(BackendUtilityCore::getRecordTitle($table, $record));
            $content .= $linkTitle;
        }

        return $content;
    }

    /**
     * Get field value from flexform configuration, including checks if flexform configuration is available
     *
     * @param string $key name of the key
     * @param string $sheet name of the sheet
     * @return string|null if nothing found, value if found
     */
    protected function getFieldFromFlexform(array $flexformData, string $key, string $sheet = 'sDEF'): ?string
    {
        if (isset($flexformData['data'])) {
            $field = $flexformData['data'][$sheet]['lDEF'][$key]['vDEF'] ?? '';
            if ($field !== '') {
                return $field;
            }
        }

        return null;
    }

    /**
     * @return LanguageService
     */
    protected function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }
}
