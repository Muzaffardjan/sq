<?php
/**
 * Sayyor qabul kunlari
 *
 * @author    Muzaffardjan Karaev
 * @copyright Copyright (c) "FOR EACH SOFT" LTD 2015 (http://www.each.uz)
 * @license   "FOR EACH SOFT" LTD PUBLIC LICENSE
 * Created:   09.03.2017
 */
return [
    'zfc_rbac' => [
        'identity_provider' => \Zend\Authentication\AuthenticationService::class,
        'guest_role' => \Users\ZfcRbac\Roles::GUESTUSER,
        'unauthorized_strategy' => [
            'template' => 'admin/layout/authorized'
        ],
        'redirect_strategy' => [
            'redirect_when_connected'        => true,
            'redirect_to_route_disconnected' => 'login',
            'append_previous_uri'            => true,
            'previous_uri_query_key'         => 'redirect_to',
        ],
        'role_provider' => [
            \ZfcRbac\Role\InMemoryRoleProvider::class => [
                \Users\ZfcRbac\Roles::SUPERUSER => [
                    'children' => [
                        \Users\ZfcRbac\Roles::ADMINUSER,
                    ],
                ],
                \Users\ZfcRbac\Roles::ADMINUSER => [
                    'children' => [
                        \Users\ZfcRbac\Roles::MODERUSER,
                    ],
                    'permissions' => [
                        'admin.main',
                    ],
                ],
                \Users\ZfcRbac\Roles::MODERUSER => [
                    'children' => [
                        \Users\ZfcRbac\Roles::DEFAULTUSER,
                    ],
                ],
                \Users\ZfcRbac\Roles::DEFAULTUSER => [
                    'children' => [
                        \Users\ZfcRbac\Roles::GUESTUSER,
                    ],
                ],
                \Users\ZfcRbac\Roles::GUESTUSER => [],
            ],
        ],
        'guards' => [
            \ZfcRbac\Guard\RouteGuard::class => [
                'app/admin*' => [
                    \Users\ZfcRbac\Roles::MODERUSER,
                ],
            ],
        ],
    ],
];