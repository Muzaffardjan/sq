<?php
/**
 * Sayyor qabul kunlari
 *
 * @author    Muzaffardjan Karaev
 * @copyright Copyright (c) "FOR EACH SOFT" LTD 2015 (http://www.each.uz)
 * @license   "FOR EACH SOFT" LTD PUBLIC LICENSE
 * Created:   09.03.2017
 */
namespace Users\Factory;

use Interop\Container\ContainerInterface;
use Users\Adapter\AuthenticationAdapter;
use Users\Service\AuthenticationService;
use Users\Service\UserService;
use Users\Storage\AuthenticationStorage;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AuthenticationServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $authenticationService = new $requestedName();

        $storage = new AuthenticationStorage($container->get(UserService::class));
        $adapter = new AuthenticationAdapter($container->get(UserService::class));

        $authenticationService->setStorage($storage);
        $authenticationService->setAdapter($adapter);

        return $authenticationService;
    }

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return $this($serviceLocator, AuthenticationService::class);
    }
}