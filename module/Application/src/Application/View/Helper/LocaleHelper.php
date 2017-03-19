<?php
/**
 * Sayyor qabul kunlari
 *
 * @author    Muzaffardjan Karaev
 * @copyright Copyright (c) "FOR EACH SOFT" LTD 2015 (http://www.each.uz)
 * @license   "FOR EACH SOFT" LTD PUBLIC LICENSE
 * Created:   09.03.2017
 */
namespace Application\View\Helper;

use Zend\I18n\Translator\TranslatorAwareInterface;
use Zend\I18n\Translator\TranslatorAwareTrait;
use Zend\I18n\Translator\TranslatorInterface;
use Zend\View\Helper\AbstractHelper;

/**
 * Class LocaleHelper
 * @package Application\View\Helper
 */
class LocaleHelper extends AbstractHelper implements TranslatorAwareInterface
{
    use TranslatorAwareTrait;

    protected $config;

    public function __construct(TranslatorInterface $translator, $config)
    {
        $this->setTranslator($translator);
        $this->setConfig($config);
    }

    public function __invoke()
    {
        return $this;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function setConfig($config)
    {
        $this->config = $config;
        return $this;
    }

    public function current()
    {
        return $this->getTranslator()->getLocale();
    }

    public function all()
    {
        $config = $this->getConfig();

        return $config['translator']['locales'];
    }
}