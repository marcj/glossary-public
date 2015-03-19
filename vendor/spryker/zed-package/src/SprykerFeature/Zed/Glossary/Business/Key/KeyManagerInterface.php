<?php

/**
 * (c) Copyright Spryker Systems GmbH 2015
 */

namespace SprykerFeature\Zed\Glossary\Business\Key;

use Propel\Runtime\Exception\PropelException;
use SprykerFeature\Zed\Glossary\Business\Exception\KeyExistsException;
use SprykerFeature\Zed\Glossary\Business\Exception\MissingKeyException;
use SprykerFeature\Zed\Glossary\Persistence\Propel\GlossaryKey;

interface KeyManagerInterface
{
    /**
     * @param string $keyName
     * @return int
     * @throws KeyExistsException
     * @throws \Exception
     * @throws PropelException
     */
    public function createKey($keyName);

    /**
     * @param string $keyName
     * @return bool
     */
    public function hasKey($keyName);

    /**
     * @param string $keyName
     * @return GlossaryKey
     * @throws MissingKeyException
     */
    public function getKey($keyName);

    /**
     * @param string $oldKeyName
     * @param string $newKeyName
     *
     * @return bool
     * @throws MissingKeyException
     */
    public function updateKey($oldKeyName, $newKeyName);

    /**
     * @param string $keyName
     *
     * @return bool
     */
    public function deleteKey($keyName);

    public function synchronizeKeys();
}
