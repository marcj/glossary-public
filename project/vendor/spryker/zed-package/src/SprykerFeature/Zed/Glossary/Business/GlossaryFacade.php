<?php

/*
 * (c) Copyright Spryker Systems GmbH 2015
 */

namespace SprykerFeature\Zed\Glossary\Business;

use ProjectA\Zed\Kernel\Business\AbstractFacade;
use SprykerCore\Zed\Locale\Business\Exception\MissingLocaleException;
use SprykerFeature\Shared\Glossary\Transfer\Translation;
use SprykerFeature\Zed\Glossary\Business\Exception;
use SprykerFeature\Zed\Glossary\Business\Exception\KeyExistsException;
use SprykerFeature\Zed\Glossary\Business\Exception\MissingKeyException;
use SprykerFeature\Zed\Glossary\Business\Exception\MissingTranslationException;
use SprykerFeature\Zed\Glossary\Business\Exception\TranslationExistsException;

class GlossaryFacade extends AbstractFacade
{

    /**
     * @var GlossaryDependencyContainer
     */
    protected $dependencyContainer;

    /**
     * @param string $keyName
     *
     * @return int
     * @throws KeyExistsException
     */
    public function createKey($keyName)
    {
        $keyManager = $this->dependencyContainer->getKeyManager();

        return $keyManager->createKey($keyName);
    }

    /**
     * @param string $keyName
     *
     * @return bool
     */
    public function hasKey($keyName)
    {
        $keyManager = $this->dependencyContainer->getKeyManager();

        return $keyManager->hasKey($keyName);
    }

    /**
     * @param string $keyName
     * @return int
     */
    public function getKeyIdentifier($keyName)
    {
        $keyManager = $this->dependencyContainer->getKeyManager();

        return $keyManager->getKey($keyName)->getPrimaryKey();
    }

    /**
     * @param string $oldKeyName
     * @param string $newKeyName
     *
     * @return bool
     * @throws MissingKeyException
     */
    public function updateKey($oldKeyName, $newKeyName)
    {
        $keyManager = $this->dependencyContainer->getKeyManager();

        return $keyManager->updateKey($oldKeyName, $newKeyName);
    }

    /**
     * @param string $keyName
     *
     * @return bool
     */
    public function deleteKey($keyName)
    {
        $keyManager = $this->dependencyContainer->getKeyManager();

        return $keyManager->deleteKey($keyName);
    }

    public function synchronizeKeys()
    {
        $keyManager = $this->dependencyContainer->getKeyManager();

        $keyManager->synchronizeKeys();
    }

    /**
     * @param string $keyName
     * @param string $localeName
     * @param string $value
     * @param bool $isActive
     *
     * @return Translation
     * @throws MissingKeyException
     * @throws MissingLocaleException
     * @throws TranslationExistsException
     */
    public function createTranslation($keyName, $localeName, $value, $isActive = true)
    {
        $translationManager = $this->dependencyContainer->getTranslationManager();
        $translationEntity = $translationManager->createTranslation($keyName, $localeName, $value, $isActive);

        return $translationManager->convertEntityToTranslationTransfer($translationEntity);
    }

    /**
     * @param $keyName
     * @param $value
     * @param bool $isActive
     *
     * @return Translation
     * @throws MissingKeyException
     * @throws MissingLocaleException
     * @throws TranslationExistsException
     */
    public function createTranslationForCurrentLocale($keyName, $value, $isActive = true)
    {
        $translationManager = $this->dependencyContainer->getTranslationManager();

        return $translationManager->createTranslationForCurrentLocale($keyName, $value, $isActive);
    }

    /**
     * @param string $keyName
     * @param string $localeName
     * @param string $value
     * @param bool $isActive
     *
     * @return Translation
     * @throws MissingKeyException
     * @throws MissingLocaleException
     * @throws TranslationExistsException
     */
    public function createAndTouchTranslation($keyName, $localeName, $value, $isActive = true)
    {
        $translationManager = $this->dependencyContainer->getTranslationManager();
        $translationEntity = $translationManager->createAndTouchTranslation($keyName, $localeName, $value, $isActive);

        return $translationManager->convertEntityToTranslationTransfer($translationEntity);
    }

    /**
     * @param string $keyName
     * @param string $localeName
     *
     * @return bool
     */
    public function hasTranslation($keyName, $localeName)
    {
        $translationManager = $this->dependencyContainer->getTranslationManager();

        return $translationManager->hasTranslation($keyName, $localeName);
    }

    /**
     * @param string $keyName
     * @param string $localeName
     *
     * @return Translation
     * @throws MissingTranslationException
     */
    public function getTranslation($keyName, $localeName)
    {
        $translationManager = $this->dependencyContainer->getTranslationManager();
        $translationEntity = $translationManager->getTranslationByNames($keyName, $localeName);

        return $translationManager->convertEntityToTranslationTransfer($translationEntity);
    }

    /**
     * @param string $keyName
     * @param string $localeName
     * @param string $value
     * @param bool $isActive
     *
     * @return Translation
     * @throws Exception\MissingTranslationException
     */
    public function updateTranslation($keyName, $localeName, $value, $isActive = true)
    {
        $translationManager = $this->dependencyContainer->getTranslationManager();
        $translationEntity = $translationManager->updateTranslation($keyName, $localeName, $value, $isActive);

        return $translationManager->convertEntityToTranslationTransfer($translationEntity);
    }

    /**
     * @param string $keyName
     * @param string $localeName
     * @param string $value
     * @param bool $isActive
     *
     * @return Translation
     * @throws Exception\MissingTranslationException
     */
    public function updateAndTouchTranslation($keyName, $localeName, $value, $isActive = true)
    {
        $translationManager = $this->dependencyContainer->getTranslationManager();
        $translationEntity = $translationManager->updateAndTouchTranslation($keyName, $localeName, $value, $isActive);

        return $translationManager->convertEntityToTranslationTransfer($translationEntity);
    }

    /**
     * @param Translation $transferTranslation
     *
     * @return Translation
     * @throws MissingKeyException
     * @throws MissingLocaleException
     * @throws TranslationExistsException
     */
    public function saveTranslation(Translation $transferTranslation)
    {
        $translationManager = $this->dependencyContainer->getTranslationManager();

        return $translationManager->saveTranslation($transferTranslation);
    }

    /**
     * @param Translation $transferTranslation
     *
     * @return Translation
     * @throws MissingKeyException
     * @throws MissingLocaleException
     * @throws TranslationExistsException
     */
    public function saveAndTouchTranslation(Translation $transferTranslation)
    {
        $translationManager = $this->dependencyContainer->getTranslationManager();

        return $translationManager->saveAndTouchTranslation($transferTranslation);
    }

    /**
     * @param string $keyName
     * @param string $localeName
     *
     * @return bool
     */
    public function deleteTranslation($keyName, $localeName)
    {
        $translationManager = $this->dependencyContainer->getTranslationManager();

        return $translationManager->deleteTranslation($keyName, $localeName);
    }

    /**
     * @param string $keyName
     * @param array $data
     *
     * @return string
     * @throws MissingTranslationException
     */
    public function translate($keyName, array $data = [])
    {
        $translationManager = $this->dependencyContainer->getTranslationManager();

        return $translationManager->translate($keyName, $data);
    }

    /**
     * @param $idKey
     * @param array $data
     *
     * @return string
     * @throws MissingTranslationException
     */
    public function translateByKeyId($idKey, array $data = [])
    {
        $translationManager = $this->dependencyContainer->getTranslationManager();

        return $translationManager->translateByKeyId($idKey, $data);
    }

    /**
     * @param int $idKey
     */
    public function touchCurrentTranslationForKeyId($idKey)
    {
        $translationManager = $this->dependencyContainer->getTranslationManager();

        $translationManager->touchCurrentTranslationForKeyId($idKey);
    }
}
