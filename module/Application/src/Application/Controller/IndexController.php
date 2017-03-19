<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return [];
    }

    public function setLocaleAction()
    {
        $application = $this->getEvent()->getApplication();
        $config      = $application->getServiceManager()->get('config');
        $locale      = $config['translator']['locale'];

        return $this->redirect()->toRoute(
            'app/home',
            ['locale' => $locale]
        );
    }
}
