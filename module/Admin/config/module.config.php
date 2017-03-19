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

use Zend\Mvc\Router\Http\Literal;
use Zend\Mvc\Router\Http\Segment;

return [
    'navigation' => [
        'admin' => [
            [
                'label'      => 'Dashboard',
                'route'      => 'javascript:void(0);',
                'category'   => true,
                'permission' => 'admin.main',
                'order'      => 1,
            ],
            [
                'label'      => 'Dashboard',
                'route'      => 'app/admin/dashboard',
                'category'   => false,
                'icon'       => 'site-menu-icon wb-dashboard',
                'permission' => 'admin.main',
                'order'      => 2,
            ],
        ],
    ],
    'controllers' => [
        'invokables' => [
            Controller\DashboardController::class => Controller\DashboardController::class,
        ],
    ],
    'router' => [
        'routes' => [
            'app' => [
                'child_routes' => [
                    'admin' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/admin',
                            'defaults' => [
                                'controller' => Controller\DashboardController::class,
                                'action' => 'index'
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'dashboard' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/dashboard',
                                    'defaults' => [
                                        'controller' => Controller\DashboardController::class,
                                        'action' => 'index',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'login' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/login',
                    'defaults' => [
                        'controller' => Controller\DashboardController::class,
                        'action' => 'index'
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'admin_layout' => 'admin/layout/layout',
        'template_path_stack' => [
            'Admin' => __DIR__ . '/../view',
        ],
    ],
    'translator' => [
        'translation_file_patterns' => [
            [
                'type'     => 'phparray',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.php',
            ]
        ],
    ],
    /*
    'doctrine' => [
        'driver' => [
            __NAMESPACE__.'_entities' => [
                'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/'.__NAMESPACE__.'/Entity'],
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__.'\Entity' => __NAMESPACE__.'_entities',
                ],
            ],
        ],
    ],
    */
];