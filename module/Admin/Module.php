<?php
/**
 * Sayyor qabul kunlari
 *
 * @author    Muzaffardjan Karaev
 * @copyright Copyright (c) "FOR EACH SOFT" LTD 2015 (http://www.each.uz)
 * @license   "FOR EACH SOFT" LTD PUBLIC LICENSE
 * Created:   09.03.2017
 */
namespace Admin;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use ZfcRbac\View\Strategy;

class Module
{
    public function onBootstrap(MvcEvent $mvcEvent)
    {
        $application  = $mvcEvent->getApplication();

        $em = $application->getEventManager();
        $sm = $application->getServiceManager();

        $moduleRouteListener = new ModuleRouteListener();

        $moduleRouteListener->attach($em);

        $sm->get(Strategy\RedirectStrategy::class)->attach($em);
        $sm->get(Strategy\UnauthorizedStrategy::class)->attach($em);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        $dir_name = __DIR__ . '/src/' . str_replace('\\', '/', __NAMESPACE__);

        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => $dir_name,
                ],
            ],
        ];
    }
}