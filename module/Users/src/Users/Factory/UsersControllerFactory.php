<?php
/**
 * Sayyor qabul kunlari
 *
 * @author    Muzaffardjan Karaev
 * @copyright Copyright (c) "FOR EACH SOFT" LTD 2015 (http://www.each.uz)
 * @license   "FOR EACH SOFT" LTD PUBLIC LICENSE
 * Created:   13.03.2017
 */
namespace Users\Factory;

use Interop\Container\ContainerInterface;
use Users\Controller\UsersController;
use Users\Form\CreateUserForm;
use Users\Service\UserService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UsersControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return $this($serviceLocator, UsersController::class);
    }

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /**
         * @var ServiceLocatorInterface $locator
         */
        $locator = $container->getServiceLocator();

        return new $requestedName(
            $locator->get(UserService::class),
            $locator->get(CreateUserForm::class)
        );
    }
}