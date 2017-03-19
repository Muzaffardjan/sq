<?php
/**
 * Sayyor qabul kunlari
 *
 * @author    Muzaffardjan Karaev
 * @copyright Copyright (c) "FOR EACH SOFT" LTD 2015 (http://www.each.uz)
 * @license   "FOR EACH SOFT" LTD PUBLIC LICENSE
 * Created:   09.03.2017
 */
namespace Application\Listeners;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;

class LocaleCheckListener extends AbstractListenerAggregate
{
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(
            MvcEvent::EVENT_DISPATCH,
            function (MvcEvent $mvcEvent) {
                $application = $mvcEvent->getApplication();
                $routeMatch  = $mvcEvent->getRouteMatch();

                $serviceManager = $application->getServiceManager();
                $eventManager   = $application->getEventManager();

                $config     = $serviceManager->get('config');
                $translator = $serviceManager->get('translator');
                $locales    = $config['translator']['locales'];

                if ($routeMatch instanceof RouteMatch) {
                    $params = $routeMatch->getParams();

                    if (isset($params['locale'])) {
                        if (!array_key_exists($params['locale'], $locales)) {
                            $eventManager->trigger(
                                MvcEvent::EVENT_DISPATCH_ERROR,
                                $mvcEvent
                            );
                        }

                        $translator->setLocale($params['locale']);
                    } else {
                        $translator->setLocale($config['translator']['locale']);
                    }
                }
            },
            2
        );
    }
}