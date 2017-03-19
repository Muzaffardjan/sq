<?php
/**
 * Sayyor qabul kunlari
 *
 * @author    Muzaffardjan Karaev
 * @copyright Copyright (c) "FOR EACH SOFT" LTD 2015 (http://www.each.uz)
 * @license   "FOR EACH SOFT" LTD PUBLIC LICENSE
 * Created:   09.03.2017
 */
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;

class AbstractAdminController extends AbstractActionController
{
    public function onDispatch(MvcEvent $e)
    {
        $application    = $e->getApplication();
        $serviceManager = $application->getServiceManager();
        $config         = $serviceManager->get('config');

        if ($config['view_manager']['admin_layout']) {
            $this->layout($config['view_manager']['admin_layout']);
        }

        return parent::onDispatch($e);
    }
}