<?php

/*
 * (c) Copyright Spryker Systems GmbH 2015
 */

namespace SprykerFeature\Zed\Glossary\Business\Translation;

use Generated\Zed\Ide\AutoCompletion;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Propel;
use SprykerCore\Zed\Locale\Business\Exception\MissingLocaleException;
use SprykerFeature\Shared\Glossary\Transfer\Translation;
use SprykerFeature\Zed\Glossary\Business\Exception\MissingKeyException;
use SprykerFeature\Zed\Glossary\Business\Exception\MissingTranslationException;
use SprykerFeature\Zed\Glossary\Business\Exception\TranslationExistsException;
use SprykerFeature\Zed\Glossary\Business\Key\KeyManagerInterface;
use SprykerFeature\Zed\Glossary\Dependency\Facade\GlossaryToLocaleInterface;
use SprykerFeature\Zed\Glossary\Dependency\Facade\GlossaryToTouchInterface;
use SprykerFeature\Zed\Glossary\Persistence\GlossaryQueryContainerInterface;
use SprykerFeature\Zed\Glossary\Persistence\Propel\GlossaryTranslation;
use SprykerFeature\Zed\Glossary\Persistence\Propel\Map\GlossaryTranslationTableMap;

class TranslationManager implements TranslationManagerInterface
{
    const TOUCH_TRANSLATION = 'translation';
    /**
     * @var GlossaryQueryContainerInterface
     */
    protected $glossaryQueryContainer;

    /**
     * @var GlossaryToTouchInterface
     */
    protected $touchFacade;

    /**
     * @var KeyManagerInterface
     */
    protected $keyManager;

    /**
     * @var GlossaryToLocaleInterface
     */
    protected $localeFacade;

    /**
     * @var AutoCompletion
     */
    protected $locator;

    /**
     * @param GlossaryQueryContainerInterface $glossaryQueryContainer
     * @param GlossaryToTouchInterface $touchFacade
     * @param GlossaryToLocaleInterface $localeFacade
     * @param KeyManagerInterface $keyManager
     * @param AutoCompletion $locator
     */
    public function __construct(
        GlossaryQueryContainerInterface $glossaryQueryContainer,
        GlossaryToTouchInterface $touchFacade,
        GlossaryToLocaleInterface $localeFacade,
        KeyManagerInterface $keyManager,
        $locator
    ) {
        $this->glossaryQueryContainer = $glossaryQueryContainer;
        $this->touchFacade = $touchFacade;
        $this->keyManager = $keyManager;
        $this->localeFacade = $localeFacade;
        $this->locator = $locator;
    }

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
    public function createTranslation($keyName, $localeName, $value, $isActive)
    {
        $idKey = $this->keyManager->getKey($keyName)->getPrimaryKey();
        $idLocale = $this->localeFacade->getLocaleIdentifier($localeName);

        $translation = $this->createTranslationByIds($idKey, $idLocale, $value, $isActive);

        return $translation;
    }

    /**
     * @param int $idKey
     * @param int $idLocale
     * @throws TranslationExistsException
     */
    protected function checkTranslationDoesNotExist($idKey, $idLocale)
    {
        if ($this->hasTranslationByIds($idKey, $idLocale)) {
            throw new TranslationExistsException(
                sprintf(
                    'Tried to create a translation for keyId %s, localeId %s, but it already exists',
                    $idKey,
                    $idLocale
                )
            );
        };
    }

    /**
     * @param int $idKey
     * @param int $idLocale
     *
     * @return bool
     */
    protected function hasTranslationByIds($idKey, $idLocale)
    {
        $translationCount = $this->glossaryQueryContainer
            ->queryTranslationByIds($idKey, $idLocale)
            ->count()
        ;

        return $translationCount > 0;
    }

    /**
     * @param string $keyName
     * @param string $localeName
     *
     * @return bool
     */
    public function hasTranslation($keyName, $localeName)
    {
        $translationCount = $this->glossaryQueryContainer
            ->queryTranslationByNames($keyName, $localeName)
            ->count();

        return $translationCount > 0;
    }

    /**
     * @param int $idKey
     * @param int $idLocale
     * @param string $value
     * @param bool $isActive
     *
     * @return GlossaryTranslation
     * @throws \Exception
     * @throws PropelException
     */
    protected function createTranslationByIds($idKey, $idLocale, $value, $isActive)
    {
        $this->checkTranslationDoesNotExist($idKey, $idLocale);

        $translation = $this->locator->glossary()->entityGlossaryTranslation();

        $translation
            ->setFkGlossaryKey($idKey)
            ->setFkLocale($idLocale)
            ->setValue($value)
            ->setIsActive($isActive);

        $translation->save();

        return $translation;
    }

    /**
     * @param GlossaryTranslation $translation
     */
    protected function insertActiveTouchRecord(GlossaryTranslation $translation)
    {
        $this->touchFacade->touchActive(
            self::TOUCH_TRANSLATION,
            $translation->getPrimaryKey()
        );
    }

    /**
     * @param GlossaryTranslation $translation
     *
     * @return Translation
     */
    public function convertEntityToTranslationTransfer(GlossaryTranslation $translation)
    {
        /** @var Translation $transferTranslation */
        $transferTranslation = $this->locator->glossary()->transferTranslation();
        $transferTranslation->fromArray($translation->toArray());

        return $transferTranslation;
    }

    /**
     * @param string $keyName
     * @param string $localeName
     * @param string $value
     * @param bool $isActive
     *
     * @return GlossaryTranslation
     * @throws MissingTranslationException
     * @throws PropelException
     */
    public function updateTranslation($keyName, $localeName, $value, $isActive)
    {
        $translation = $this->getUpdatedTranslationEntity($keyName, $localeName, $value, $isActive);

        return $this->doUpdateTranslation($translation);
    }

    /**
     * @param string $keyName
     * @param string $localeName
     * @param string $value
     * @param bool $isActive
     *
     * @return GlossaryTranslation
     * @throws MissingTranslationException
     */
    protected function getUpdatedTranslationEntity($keyName, $localeName, $value, $isActive)
    {
        $translation = $this->getTranslationByNames($keyName, $localeName);

        $translation->setValue($value);
        $translation->setIsActive($isActive);

        return $translation;
    }

    /**
     * @param string $keyName
     * @param string $localeName
     *
     * @return GlossaryTranslation
     * @throws MissingTranslationException
     */
    public function getTranslationByNames($keyName, $localeName)
    {
        $translation = $this->glossaryQueryContainer
            ->queryTranslationByNames($keyName, $localeName)
            ->findOne();
        if (!$translation) {
            throw new MissingTranslationException(
                sprintf('Could not find a translation for key %s, locale %s', $keyName, $localeName)
            );
        }

        return $translation;
    }

    /**
     * @param GlossaryTranslation $translation
     */
    protected function insertDeletedTouchRecord(GlossaryTranslation $translation)
    {
        $this->touchFacade->touchDeleted(
            self::TOUCH_TRANSLATION,
            $translation->getPrimaryKey()
        );
    }

    /**
     * @param string $keyName
     * @param string $localeName
     *
     * @return bool
     */
    public function deleteTranslation($keyName, $localeName)
    {
        if (!$this->hasTranslation($keyName, $localeName)) {
            return true;
        }

        $translation = $this->getTranslationByNames($keyName, $localeName);

        $translation->setIsActive(false);

        if ($translation->isModified()) {
            $translation->save();
            $this->insertDeletedTouchRecord($translation);
        }

        return true;
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
        $localeName = $this->localeFacade->getCurrentLocale();
        $translation = $this->getTranslationByNames($keyName, $localeName);

        return str_replace(array_keys($data), array_values($data), $translation->getValue());
    }

    /**
     * @param Translation $transferTranslation
     *
     * @return Translation
     * @throws MissingKeyException
     * @throws MissingLocaleException
     * @throws TranslationExistsException
     * @throws MissingTranslationException
     */
    public function saveTranslation(Translation $transferTranslation)
    {
        if (is_null($transferTranslation->getIdGlossaryTranslation())) {
            $translationEntity = $this->createTranslationFromTransfer($transferTranslation);
            $transferTranslation->setIdGlossaryTranslation($translationEntity->getPrimaryKey());

            return $transferTranslation;
        } else {
            $translationEntity = $this->getTranslationFromTransfer($transferTranslation);
            $this->doUpdateTranslation($translationEntity);

            return $transferTranslation;
        }
    }

    /**
     * @param Translation $transferTranslation
     *
     * @return Translation
     * @throws MissingKeyException
     * @throws MissingLocaleException
     * @throws TranslationExistsException
     * @throws MissingTranslationException
     */
    public function saveAndTouchTranslation(Translation $transferTranslation)
    {
        if (is_null($transferTranslation->getIdGlossaryTranslation())) {
            $translationEntity = $this->createAndTouchTranslationFromTransfer($transferTranslation);
            $transferTranslation->setIdGlossaryTranslation($translationEntity->getPrimaryKey());

            return $transferTranslation;
        } else {
            $translationEntity = $this->getTranslationFromTransfer($transferTranslation);
            $this->doUpdateAndTouchTranslation($translationEntity);

            return $transferTranslation;
        }
    }

    /**
     * @param Translation $transferTranslation
     *
     * @return GlossaryTranslation
     */
    protected function createTranslationFromTransfer(Translation $transferTranslation)
    {
        $newEntity = $this->createTranslationByIds(
            $transferTranslation->getFkGlossaryKey(),
            $transferTranslation->getFkLocale(),
            $transferTranslation->getValue(),
            $transferTranslation->getIsActive()
        );

        return $newEntity;
    }

    /**
     * @param Translation $transferTranslation
     *
     * @return GlossaryTranslation
     */
    protected function createAndTouchTranslationFromTransfer(Translation $transferTranslation)
    {
        Propel::getConnection()->beginTransaction();

        $newEntity = $this->createTranslationFromTransfer($transferTranslation);

        if ($newEntity->getIsActive()) {
            $this->insertActiveTouchRecord($newEntity);
        }

        Propel::getConnection()->commit();

        return $newEntity;
    }

    /**
     * @param int $idKey
     * @param int $idLocale
     *
     * @return GlossaryTranslation
     * @throws MissingTranslationException
     */
    protected function getTranslationByIds($idKey, $idLocale)
    {
        $translation = $this->glossaryQueryContainer
            ->queryTranslationByIds($idKey, $idLocale)
            ->findOne()
        ;

        if (!$translation) {
            throw new MissingTranslationException(
                sprintf('Could not find a translation for keyId %s, localeId %s', $idKey, $idLocale)
            );
        }

        return $translation;
    }

    /**
     * @param Translation $transferTranslation
     *
     * @return GlossaryTranslation
     * @throws MissingTranslationException
     */
    protected function getTranslationFromTransfer(Translation $transferTranslation)
    {
        $translation = $this->getTranslationById($transferTranslation->getIdGlossaryTranslation());
        $translation->fromArray($transferTranslation->toArray());

        return $translation;
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
        $idLocale = $this->localeFacade->getLocaleIdentifier($this->localeFacade->getCurrentLocale());
        $translation = $this->getTranslationByIds($idKey, $idLocale);

        return str_replace(array_keys($data), array_values($data), $translation->getValue());
    }

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
    public function createTranslationForCurrentLocale($keyName, $value, $isActive = true)
    {
        $localeName = $this->localeFacade->getCurrentLocale();

        return $this->createTranslation($keyName, $localeName, $value, $isActive);
    }

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
    public function createAndTouchTranslation($keyName, $localeName, $value, $isActive = true)
    {
        Propel::getConnection()->beginTransaction();

        $translation = $this->createTranslation($keyName, $localeName, $value, $isActive);
        if ($isActive) {
            $this->insertActiveTouchRecord($translation);
        }
        Propel::getConnection()->commit();

        return $translation;
    }

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
    public function updateAndTouchTranslation($keyName, $localeName, $value, $isActive = true)
    {
        $translation = $this->getUpdatedTranslationEntity($keyName, $localeName, $value, $isActive);
        $this->doUpdateAndTouchTranslation($translation);

        return $translation;
    }

    /**
     * @param GlossaryTranslation $translation

     * @return GlossaryTranslation
     */
    protected function doUpdateTranslation(GlossaryTranslation $translation)
    {
        if ($translation->isModified()) {
            $translation->save();
        }

        return $translation;
    }

    /**
     * @param GlossaryTranslation $translation

     * @return GlossaryTranslation
     * @throws \Exception
     * @throws PropelException
     */
    protected function doUpdateAndTouchTranslation(GlossaryTranslation $translation)
    {
        if (!$translation->isModified()) {
            return $translation;
        }

        Propel::getConnection()->beginTransaction();

        $isActiveModified = $translation->isColumnModified(
            GlossaryTranslationTableMap::COL_IS_ACTIVE
        );

        $translation->save();

        if ($translation->getIsActive()) {
            $this->insertActiveTouchRecord($translation);
        } elseif ($isActiveModified) {
            $this->insertDeletedTouchRecord($translation);
        }

        Propel::getConnection()->commit();

        return $translation;
    }

    /**
     * @param int $idTranslation
     *
     * @return GlossaryTranslation
     * @throws MissingTranslationException
     */
    protected function getTranslationById($idTranslation)
    {
        $translation = $this->glossaryQueryContainer->queryTranslations()->findPk($idTranslation);
        if (!$translation) {
            throw new MissingTranslationException(
                sprintf('Could not find a translation with id %s', $idTranslation)
            );
        }

        return $translation;
    }

    /**
     * @param int $idKey
     */
    public function touchCurrentTranslationForKeyId($idKey)
    {
        $idLocale = $this->localeFacade->getCurrentLocaleIdentifier();
        $translation = $this->getTranslationByIds($idKey, $idLocale);
        $this->insertActiveTouchRecord($translation);
    }
}
