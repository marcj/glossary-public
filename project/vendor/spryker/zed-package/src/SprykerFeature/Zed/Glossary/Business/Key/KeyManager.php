<?php

/*
 * (c) Copyright Spryker Systems GmbH 2015
 */

namespace SprykerFeature\Zed\Glossary\Business\Key;

use Generated\Zed\Ide\AutoCompletion;
use ProjectA\Shared\Kernel\LocatorLocatorInterface;
use Propel\Runtime\Exception\PropelException;
use SprykerFeature\Zed\Glossary\Business\Exception\KeyExistsException;
use SprykerFeature\Zed\Glossary\Business\Exception\MissingKeyException;
use SprykerFeature\Zed\Glossary\Persistence\GlossaryQueryContainerInterface;
use SprykerFeature\Zed\Glossary\Persistence\Propel\GlossaryKey;

/**
 * Class KeyManager
 *
 * @package ProjectA\Zed\Glossary\Manager
 */
class KeyManager implements KeyManagerInterface
{
    /**
     * @var GlossaryQueryContainerInterface
     */
    protected $queryContainer;

    /**
     * @var KeySourceInterface
     */
    protected $keySource;

    /**
     * @var AutoCompletion
     */
    protected $locator;

    /**
     * @param KeySourceInterface $keySource
     * @param GlossaryQueryContainerInterface $queryContainer
     * @param LocatorLocatorInterface $locator
     */
    public function __construct(KeySourceInterface $keySource, GlossaryQueryContainerInterface $queryContainer, LocatorLocatorInterface $locator)
    {
        $this->keySource = $keySource;
        $this->queryContainer = $queryContainer;
        $this->locator = $locator;
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
        $this->checkKeyDoesExist($oldKeyName);

        $key = $this->getKey($oldKeyName);
        $key->setKey($newKeyName);

        return true;
    }

    /**
     * @param $oldKeyName
     * @throws MissingKeyException
     */
    protected function checkKeyDoesExist($oldKeyName)
    {
        if (!$this->hasKey($oldKeyName)) {
            throw new MissingKeyException(
                sprintf(
                    'Tried to update key %s, but it does not exist',
                    $oldKeyName
                )
            );
        }
    }

    /**
     * @param string $keyName
     * @return bool
     */
    public function hasKey($keyName)
    {
        $keyQuery = $this->queryContainer->queryKey($keyName);
        return $keyQuery->count() > 0;
    }

    /**
     * @param string $keyName
     * @return GlossaryKey
     * @throws MissingKeyException
     */
    public function getKey($keyName)
    {
        $key = $this->queryContainer->queryKey($keyName)
            ->findOne();
        if (!$key) {
            throw new MissingKeyException('Tried to retrieve a missing glossary key');
        }

        return $key;
    }

    /**
     * @param string $keyName
     *
     * @return bool
     */
    public function deleteKey($keyName)
    {
        $keyQuery = $this->queryContainer->queryKey($keyName);
        $entity = $keyQuery->findOne();
        if (!$entity) {
            return true;
        }
        $entity->setIsActive(false);
        $entity->save();

        return true;
    }

    public function synchronizeKeys()
    {
        $keyArray = $this->keySource->retrieveKeyArray();

        foreach ($keyArray as $keyName) {
            $keyQuery = $this->queryContainer->queryKey($keyName);
            $keyCount = $keyQuery
                ->count();

            if ($keyCount === 0) {
                $this->createKey($keyName);
            }
        }
    }

    /**
     * @param string $keyName
     * @return int
     * @throws KeyExistsException
     * @throws \Exception
     * @throws PropelException
     */
    public function createKey($keyName)
    {
        $this->checkKeyDoesNotExist($keyName);

        $keyEntity = $this->locator->glossary()->entityGlossaryKey();
        $keyEntity->setKey($keyName);
        $keyEntity->save();

        return $keyEntity->getPrimaryKey();
    }

    /**
     * @param $keyName
     * @throws KeyExistsException
     */
    protected function checkKeyDoesNotExist($keyName)
    {
        if ($this->hasKey($keyName)) {
            throw new KeyExistsException(
                sprintf(
                    'Tried to create key %s, but it already exists',
                    $keyName
                )
            );
        }
    }
}
