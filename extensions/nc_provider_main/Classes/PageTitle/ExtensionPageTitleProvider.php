<?php

declare(strict_types=1);

namespace NC\NcProviderMain\PageTitle;

/*
 * global pageTitle helper for extension records see https://brot.krue.ml/post/2018/setting-the-page-title-in-typo3/
 * Code from https://github.com/brotkrueml/extpagetitle
 */

use TYPO3\CMS\Core\PageTitle\AbstractPageTitleProvider;

class ExtensionPageTitleProvider extends AbstractPageTitleProvider
{
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
}
