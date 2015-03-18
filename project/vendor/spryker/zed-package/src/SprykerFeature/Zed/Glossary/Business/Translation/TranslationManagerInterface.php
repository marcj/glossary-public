<?php

/*
 * (c) Copyright Spryker Systems GmbH 2015
 */

namespace SprykerFeature\Zed\Glossary\Business\Translation;

use Propel\Runtime\Exception\PropelException;
use SprykerCore\Zed\Locale\Business\Exception\MissingLocaleException;
use SprykerFeature\Shared\Glossary\Transfer\Translation;
use SprykerFeature\Zed\Glossary\Business\Exception\MissingKeyException;
use SprykerFeature\Zed\Glossary\Business\Exception\MissingTranslationException;
use SprykerFeature\Zed\Glossary\Business\Exception\TranslationExistsException;
use SprykerFeature\Zed\Glossary\Persistence\Propel\GlossaryTranslation;

interface TranslationManagerInterface
{
    /**
     * @param string $keyName
     * @param string $localeName
     * @param string $value
     * @param bool $isActive
     *
     * @return GlossaryTranslation
     * @throws MissingKeyException
     * @throws MissingLocaleException
     * @throws TranslationExistsException
     */
    public function createTranslation($keyName, $localeName, $value, $isActive);

    /**
     * @param string $keyName
     * @param string $value
     * @param bool $isActive
     *
     * @return Translation
     * @throws MissingKeyException
     * @throws MissingLocaleException
     * @throws TranslationExistsException
     */
    public function createTranslationForCurrentLocale($keyName, $value, $isActive = true);

    /**
     * @param string $keyName
     * @param string $localeName
     * @param string $value
     * @param bool $isActive
     *
     * @return GlossaryTranslation
     * @throws MissingKeyException
     * @throws MissingLocaleException
     * @throws TranslationExistsException
     */
    public function createAndTouchTranslation($keyName, $localeName, $value, $isActive = true);

    /**
     * @param string $keyName
     * @param string $localeName
     * @param string $value
     * @param bool $isActive
     *
     * @return GlossaryTranslation
     * @throws MissingTranslationException
     * @throws \Exception
     * @throws PropelException
     */
    public function updateTranslation($keyName, $localeName, $value, $isActive);

    /**
     * @param $keyName
     * @param $localeName
     * @param $value
     * @param bool $isActive
     *
     * @return GlossaryTranslation
     * @throws MissingKeyException
     * @throws MissingLocaleException
     * @throws MissingTranslationException
     */
    public function updateAndTouchTranslation($keyName, $localeName, $value, $isActive = true);

    /**
     * @param Translation $transferTranslation
     *
     * @return Translation
     * @throws MissingKeyException
     * @throws MissingLocaleException
     * @throws TranslationExistsException
     * @throws MissingTranslationException
     */
    public function saveTranslation(Translation $transferTranslation);

    /**
     * @param Translation $transferTranslation
     *
     * @return Translation
     * @throws MissingKeyException
     * @throws MissingLocaleException
     * @throws TranslationExistsException
     * @throws MissingTranslationException
     */
    public function saveAndTouchTranslation(Translation $transferTranslation);

    /**
     * @param string $keyName
     * @param string $localeName
     *
     * @return bool
     */
    public function hasTranslation($keyName, $localeName);

    /**
     * @param string $keyName
     * @param string $localeName
     *
     * @return bool
     */
    public function deleteTranslation($keyName, $localeName);

    /**
     * @param string $keyName
     * @param array $data
     *
     * @return string
     */
    public function translate($keyName, array $data = []);

    public function translateByKeyId($idKey, array $data = []);

    /**
     * @param GlossaryTranslation $translation
     * @return Translation
     */
    public function convertEntityToTranslationTransfer(GlossaryTranslation $translation);

    /**
     * @param string $keyName
     * @param string $localeName
     *
     * @return GlossaryTranslation
     * @throws MissingTranslationException
     */
    public function getTranslationByNames($keyName, $localeName);

    /**
     * @param int $idKey
     */
    public function touchCurrentTranslationForKeyId($idKey);
}
