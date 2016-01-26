<?php
return array(
    'listeners' => array(
        'MySampleListener'
    ),
    'modules' => array(
        'Application',
        'DoctrineModule',
        'DoctrineORMModule',
        'MyDoctrineAuth',
        'Album',
       // 'Users'
    ),
    'module_listener_options' => array(
        'config_glob_paths'    => array(
            'config/autoload/{,*.}{global,local}.php',
        ),
        'module_paths' => array(
            './module',
            './vendor',
        ),
    ),
);
