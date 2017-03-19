<?php
/**
 * Sayyor qabul kunlari
 *
 * @author    Muzaffardjan Karaev
 * @copyright Copyright (c) "FOR EACH SOFT" LTD 2015 (http://www.each.uz)
 * @license   "FOR EACH SOFT" LTD PUBLIC LICENSE
 * Created:   10.03.2017
 */
namespace Users\Factory;

use Interop\Container\ContainerInterface;
use Users\Controller\AuthController;
use Users\Form\LoginForm;
use Users\Form\RegisterForm;
use Users\Service\AuthenticationService;
use Users\Service\UserService;
use Zend\Mvc\Router\Http\RouteMatch;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AuthControllerFactory implements FactoryInterface
{
    protected $form;

    /**
     * @param ContainerInterface $container
     * @param $requestedName
     * @param array|null $options
     * @return mixed
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /**
         * @var ServiceLocatorInterface $locator
         */
        $locator     = $container->getServiceLocator();
        $application = $locator->get('Application');
        /**
         * @var RouteMatch $routeMatch
         */
        $routeMatch  = $application->getMvcEvent()->getRouteMatch();

        switch ($routeMatch->getParam('action')) {
            case 'login':
                return new $requestedName(
                    $locator->get(AuthenticationService::class),
                    $locator->get(UserService::class),
                    $locator->get(LoginForm::class)
                );
                break;
            case 'register':
                return new $requestedName(
                    $locator->get(AuthenticationService::class),
                    $locator->get(UserService::class),
                    $locator->get(RegisterForm::class)
                );
                break;
            default:
                return new $requestedName(
                    $locator->get(AuthenticationService::class),
                    $locator->get(UserService::class)
                );
                break;
        }
    }

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return $this($serviceLocator, AuthController::class);
    }
}