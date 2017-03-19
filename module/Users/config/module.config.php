<?php
/**
 * Sayyor qabul kunlari
 *
 * @author    Muzaffardjan Karaev
 * @copyright Copyright (c) "FOR EACH SOFT" LTD 2015 (http://www.each.uz)
 * @license   "FOR EACH SOFT" LTD PUBLIC LICENSE
 * Created:   09.03.2017
 */
namespace Users;

use Zend\Mvc\Router\Http\Literal;
use Zend\Mvc\Router\Http\Segment;

return [
    'navigation' => [
        'admin' => [
            [
                'label'      => 'Users',
                'route'      => 'javascript:void(0);',
                'category'   => true,
                'permission' => 'user.main',
                'order'      => 3,
            ],
            [
                'label'      => 'Create',
                'route'      => 'app/admin/users/create',
                'category'   => false,
                'icon'       => 'site-menu-icon wb-user-add',
                'permission' => 'user.main',
                'order'      => 4,
            ],
            [
                'label'      => 'List',
                'route'      => 'app/admin/users',
                'category'   => false,
                'icon'       => 'site-menu-icon wb-user',
                'permission' => 'user.main',
                'order'      => 5,
            ],
        ],
    ],
    'zfc_rbac' => [
        'role_provider' => [
            \ZfcRbac\Role\InMemoryRoleProvider::class => [
                \Users\ZfcRbac\Roles::SUPERUSER => [
                    'permissions' => [
                        'user.main',
                    ],
                ],
            ],
        ],
        'guards' => [
            \ZfcRbac\Guard\RouteGuard::class => [
                'app/admin/users' => [
                    \Users\ZfcRbac\Roles::SUPERUSER,
                ],
            ],
        ],
    ],
    'service_manager' => [
        'aliases' => [
            \Zend\Authentication\AuthenticationService::class =>
                Service\AuthenticationService::class,
        ],
        'factories' => [
            Service\AuthenticationService::class =>
                Factory\AuthenticationServiceFactory::class,
            Service\UserService::class => Factory\UserServiceFactory::class,
        ],
        'invokables' => [
            Form\RegisterForm::class => Form\RegisterForm::class,
            Form\LoginForm::class => Form\LoginForm::class,
            Form\CreateUserForm::class => Form\CreateUserForm::class,
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\AuthController::class =>
                Factory\AuthControllerFactory::class,
            Controller\UsersController::class =>
                Factory\UsersControllerFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'app' => [
                'child_routes' => [
                    'admin' => [
                        'child_routes' => [
                            'users' => [
                                'type' => Literal::class,
                                'options' => [
                                    'route' => '/users',
                                    'defaults' => [
                                        'controller' => Controller\UsersController::class,
                                        'action'     => 'index',
                                    ],
                                ],
                                'may_terminate' => true,
                                'child_routes' => [
                                    'create' => [
                                        'type' => Segment::class,
                                        'options' => [
                                            'route' => '/create',
                                            'defaults' => [
                                                'controller' => Controller\UsersController::class,
                                                'action' => 'create',
                                            ],
                                        ],
                                    ],
                                    'edit' => [
                                        'type' => Segment::class,
                                        'options' => [
                                            'route' => '/edit[/:id]',
                                            'constraints' => [
                                                'id' => '[0-9]+',
                                            ],
                                            'defaults' => [
                                                'controller' => Controller\UsersController::class,
                                                'action' => 'edit',
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'login' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/login[/:locale]',
                    'constraints' => [
                        'locale' => '[a-z]{2}-[a-z]{2}',
                    ],
                    'defaults' => [
                        'controller' => Controller\AuthController::class,
                        'action' => 'login',
                    ],
                ],
            ],
            'logout' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/logout',
                    'defaults' => [
                        'controller' => Controller\AuthController::class,
                        'action' => 'logout',
                    ],
                ],
            ],
            'register' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/register[/:locale]',
                    'constraints' => [
                        'locale' => '[a-z]{2}-[a-z]{2}',
                    ],
                    'defaults' => [
                        'controller' => Controller\AuthController::class,
                        'action' => 'register',
                    ],
                ],
            ],
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
    'doctrine' => [
        'driver' => [
            __NAMESPACE__.'_annotation_driver' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'],
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ => __NAMESPACE__.'_annotation_driver'
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'Users' => __DIR__ . '/../view',
        ],
    ],
    'console' => [
        'router' => [
            'routes' => [
                'create-super-user' => [
                    'options' => [
                        'route' => 'create super user <username> <password> <email>',
                        'defaults' => [
                            'controller'    => Controller\AuthController::class,
                            'action'        => 'create-superuser'
                        ],
                    ],
                ],
            ],
        ],
    ],
];