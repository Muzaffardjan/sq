<?php
/**
 * Sayyor qabul kunlari
 *
 * @author    Muzaffardjan Karaev
 * @copyright Copyright (c) "FOR EACH SOFT" LTD 2015 (http://www.each.uz)
 * @license   "FOR EACH SOFT" LTD PUBLIC LICENSE
 * Created:   11.03.2017
 */
namespace Application\Factory;

use Application\Controller\Plugin\LocalePlugin;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LocalePluginFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return $this($serviceLocator, LocalePlugin::class);
    }

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $container  = $container->getServiceLocator();
        $translator = $container->get('translator');
        $config     = $container->get('config');

        return new $requestedName($translator, $config);
    }
}