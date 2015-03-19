<?php

/*
 * (c) Copyright Spryker Systems GmbH 2015
 */

namespace SprykerFeature\Zed\Glossary\Communication\Grid;

use ProjectA\Zed\Ui\Dependency\Grid\AbstractGrid;

class TranslationGrid extends AbstractGrid
{

    const LOCALE = 'locale';
    const TRANSLATION = 'translation';
    const TRANSLATION_IS_ACTIVE = 'translation_is_active';
    const GLOSSARY_KEY = 'glossary_key';
    const GLOSSARY_KEY_IS_ACTIVE = 'glossary_key_is_active';

    /**
     * @return array
     */
    public function definePlugins()
    {
        $plugins = [
            $this->locator->ui()->pluginGridDefaultRowsRenderer(),
            $this->locator->ui()->pluginGridPagination(),
            $this->locator->ui()->pluginGridDefaultColumn()
                ->setName(self::LOCALE)
                ->filterable()
                ->sortable(),
            $this->locator->ui()->pluginGridDefaultColumn()
                ->setName(self::TRANSLATION)
                ->filterable()
                ->sortable(),
            $this->locator->ui()->pluginGridDefaultColumn()
                ->setName(self::TRANSLATION_IS_ACTIVE)
                ->filterable()
                ->sortable(),
            $this->locator->ui()->pluginGridDefaultColumn()
                ->setName(self::GLOSSARY_KEY)
                ->filterable()
                ->sortable(),
            $this->locator->ui()->pluginGridDefaultColumn()
                ->setName(self::GLOSSARY_KEY_IS_ACTIVE)
                ->filterable()
                ->sortable()
        ];

        return $plugins;
    }

}