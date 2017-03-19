<?php
/**
 * Sayyor qabul kunlari
 *
 * @author    Muzaffardjan Karaev
 * @copyright Copyright (c) "FOR EACH SOFT" LTD 2015 (http://www.each.uz)
 * @license   "FOR EACH SOFT" LTD PUBLIC LICENSE
 * Created:   09.03.2017
 */
namespace Application\Factory;

use Application\View\Helper\LocaleHelper;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LocaleFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return $this($serviceLocator, LocaleHelper::class);
    }

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $container  = $container->getServiceLocator();
        $translator = $container->get('translator');
        $config     = $container->get('config');

        return new $requestedName($translator, $config);
    }
}