<?php
namespace Registry\View\Helper;

use Zend\View\Helper\AbstractHtmlElement;
use Zend\I18n\Translator\TranslatorAwareInterface;
use Zend\I18n\Translator\TranslatorInterface as Translator;

abstract class AbstractHtmlTranslatorHelper extends AbstractHtmlElement implements TranslatorAwareInterface
{
    /**
     * Translator (optional)
     *
     * @var Translator
     */
    protected $translator;

    /**
     * Translator text domain (optional)
     *
     * @var string
     */
    protected $translatorTextDomain = 'default';

    /**
     * Whether translator should be used
     *
     * @var bool
     */
    protected $translatorEnabled = true;

    /**
     * Sets translator to use in helper
     *
     * @param  Translator     $translator [optional] translator.
     *                                    Default is null, which sets no translator.
     * @param  string         $textDomain [optional] text domain
     *                                    Default is null, which skips setTranslatorTextDomain
     * @return AbstractHelper
     */
    public function setTranslator(Translator $translator = null, $textDomain = null)
    {
        $this->translator = $translator;
        if (null !== $textDomain) {
            $this->setTranslatorTextDomain($textDomain);
        }

        return $this;
    }

    /**
     * Returns translator used in helper
     *
     * @return Translator|null
     */
    public function getTranslator()
    {
        if (! $this->isTranslatorEnabled()) {
            return null;
        }

        return $this->translator;
    }

    /**
     * Checks if the helper has a translator
     *
     * @return bool
     */
    public function hasTranslator()
    {
        return (bool) $this->getTranslator();
    }

    /**
     * Sets whether translator is enabled and should be used
     *
     * @param  bool           $enabled
     * @return AbstractHelper
     */
    public function setTranslatorEnabled($enabled = true)
    {
        $this->translatorEnabled = (bool) $enabled;

        return $this;
    }

    /**
     * Returns whether translator is enabled and should be used
     *
     * @return bool
     */
    public function isTranslatorEnabled()
    {
        return $this->translatorEnabled;
    }

    /**
     * Set translation text domain
     *
     * @param  string         $textDomain
     * @return AbstractHelper
     */
    public function setTranslatorTextDomain($textDomain = 'default')
    {
        $this->translatorTextDomain = $textDomain;

        return $this;
    }

    /**
     * Return the translation text domain
     *
     * @return string
     */
    public function getTranslatorTextDomain()
    {
        return $this->translatorTextDomain;
    }
}
