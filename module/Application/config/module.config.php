<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\Router\Http\Literal;
use Zend\Mvc\Router\Http\Regex;
use Zend\Mvc\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'set-locale',
                    ],
                ],
            ],
            'app' => [
                'type' => Regex::class,
                'options' => [
                    'regex' => '/(?<locale>[a-zA-Z_-]+)',
                    'spec' => '/%locale%',
                    'defaults' => [
                        'locale' => 'uz-oz',
                    ],
                ],
                'may_terminate' => false,
                'child_routes' => [
                    'home' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '[/:locale]',
                            'defaults' => [
                                'controller' => Controller\IndexController::class,
                                'action'     => 'index',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'abstract_factories' => [
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
            'Zend\Navigation\Service\NavigationAbstractServiceFactory',
        ],
        'factories' => [
            'translator' => 'Zend\Mvc\Service\TranslatorServiceFactory',
        ],
        'invokables' => [
            Listeners\LocaleCheckListener::class => Listeners\LocaleCheckListener::class,
        ],
    ],
    'controllers' => [
        'invokables' => [
            Controller\IndexController::class => Controller\IndexController::class,
        ],
    ],
    'controller_plugins' => [
        'factories' => [
            'locale' => Factory\LocalePluginFactory::class,
        ],
    ],
    'view_helpers' => [
        'factories' => [
            'locale' => Factory\LocaleFactory::class,
        ],
        'invokables' => [
            'inlineComponent' => View\Helper\InlineComponent::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'console' => [
        'router' => [
            'routes' => [
            ],
        ],
    ],
];
