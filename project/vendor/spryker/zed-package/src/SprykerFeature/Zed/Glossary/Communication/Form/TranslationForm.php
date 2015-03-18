<?php

/*
 * (c) Copyright Spryker Systems GmbH 2015
 */

namespace SprykerFeature\Zed\Glossary\Communication\Form;

use ProjectA\Shared\Kernel\AbstractLocatorLocator;
use ProjectA\Zed\Kernel\Persistence\AbstractQueryContainer;
use ProjectA\Zed\Library\Propel\Formatter\PropelArraySetFormatter;
use ProjectA\Zed\Ui\Communication\Plugin\Form\Field;
use ProjectA\Zed\Ui\Dependency\Form\AbstractForm;
use Propel\Runtime\Exception\PropelException;
use SprykerFeature\Zed\Glossary\Dependency\Facade\GlossaryToLocaleInterface;
use SprykerFeature\Zed\Glossary\Persistence\GlossaryQueryContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class TranslationForm extends AbstractForm
{
    /**
     * @var GlossaryQueryContainerInterface
     */
    protected $queryContainer;

    /**
     * @var GlossaryToLocaleInterface
     */
    protected $localeFacade;

    public function __construct(
        AbstractLocatorLocator $locator,
        $localeFacade,
        Request $request,
        AbstractQueryContainer $queryContainer
    ) {
        parent::__construct($locator, $request, $queryContainer);
        $this->localeFacade = $localeFacade;
    }

    /**
     * @return Field[]
     */
    public function addPlugins()
    {
        $keyChoices = $this->getNotFullyTranslatedGlossaryKeys();
        $localeChoices = $this->getLocales();

        $fields[] = $this->addField('id_glossary_translation')
            ->setConstraints([
                new Assert\Optional([
                    new Assert\Type([
                        'type' => 'integer'
                    ])
                ])
            ]);

        $fields[] = $this->addField('fk_glossary_key')
            ->setAccepts($keyChoices)
            ->setRefresh(true)
            ->setConstraints([
                new Assert\Type([
                    'type' => 'integer'
                ]),
                new Assert\Choice([
                    'choices' => array_column($keyChoices, 'value'),
                    'message' => 'Please choose one of the given Glossary Keys'
                ])
            ])
            ->setValueHook(function ($value) {
                return $value ? (int)$value : null;
            });

        $fields[] = $this->addField('fk_locale')
            ->setAccepts($localeChoices)
            ->setConstraints([
                new Assert\Type([
                    'type' => 'integer'
                ]),
                new Assert\Choice([
                    'choices' => array_column($localeChoices, 'value'),
                    'message' => 'Please choose one of the given Locales Keys'
                ])
            ])
            ->setValueHook(function ($value) {
                return $value ? (int)$value : null;
            });

        $fields[] = $this->addField('value')
            ->setName('value');

        $fields[] = $this->addField('is_active')
            ->setConstraints([
                new Assert\Type([
                    'type' => 'bool'
                ]),
            ]);

        return $fields;
    }

    /**
     * @return array
     */
    public function getResponseData()
    {
        $idGlossaryTranslation = $this->stateContainer->getRequestValue('id_glossary_translation');
        $translationQuery = $this->queryContainer->queryTranslationByPk($idGlossaryTranslation);
        $translationCount = $translationQuery->count();

        if ($translationCount) {
            return $translationQuery->findOne()->toArray();
        }

        return [];
    }
        
    /**
     * @return array
     * @throws PropelException
     */
    protected function getNotFullyTranslatedGlossaryKeys()
    {
        $query = $this->queryContainer->queryAllMissingTranslations($this->localeFacade->getRelevantLocales());
        $query = $this->queryContainer->queryDistinctKeysFromQuery($query);

        $query->setFormatter(new PropelArraySetFormatter());

        $glossaryKeys = $query->find();

        $glossaryKeys = array_map(function ($element) {
            $element['value'] = (int)$element['value'];
            return $element;
        }, $glossaryKeys);

        return $glossaryKeys;
    }

    /**
     * @return array
     */
    private function getLocales()
    {
        $fkGlossaryKey = $this->getStateContainer()->getLatestValue('fk_glossary_key');
        if (!$fkGlossaryKey) {
            return [];
        }

        $locales = $this->getLocalesForKey($fkGlossaryKey);
        $idGlossaryTranslation = $this->getStateContainer()->getLatestValue('id_glossary_translation');

        if (!$idGlossaryTranslation) {
            return $locales;
        }

        $translationEntity = $this->queryContainer->queryTranslations()->findPk($idGlossaryTranslation);
        if ($fkGlossaryKey !== $translationEntity->getFkGlossaryKey()) {
            return $locales;
        }

        $currentTranslationLocale = $this->queryContainer->queryTranslations()->findPk($idGlossaryTranslation)
            ->getGlossaryLocale();

        $locales[] = [
            'value' => $currentTranslationLocale->getPrimaryKey(),
            'label' => $currentTranslationLocale->getLocaleName()
        ];

        return $locales;
    }

    /**
     * @param $idKey
     *
     * @return array|null
     */
    protected function getLocalesForKey($idKey)
    {
        $query = $this->queryContainer->queryMissingTranslationsForKey($idKey, $this->localeFacade->getRelevantLocales());
        $query = $this->queryContainer->queryDistinctLocalesFromQuery($query);
        $query->setFormatter(new PropelArraySetFormatter());

        $locales = $query->find();

        $locales = array_map(function ($element) {
            $element['value'] = (int)$element['value'];
            return $element;
        }, $locales);

        return $locales;
    }
}

// PHP < 5.5 Fallback
if (!function_exists('array_column')) {
    function array_column(array $a, $name)
    {
        $b = [];
        foreach ($a as $aa) {
            if (isset($aa[$name])) {
                $b[] = $aa[$name];
            }
        }

        return $b;
    }
}
