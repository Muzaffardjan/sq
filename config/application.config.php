<?php
return [
    'modules' => [
        //'ZendDeveloperTools',
        'DoctrineModule',
        'DoctrineORMModule',
        'ZfcRbac',
        'Application',
        'Admin',
        'Users',
    ],
    'module_listener_options' => [
        'module_paths' => [
            './module',
            './vendor',
        ],
        'config_glob_paths' => [
            'config/autoload/{{,*.}global,{,*.}local}.php',
        ],
    ],
];
