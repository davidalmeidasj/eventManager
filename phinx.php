<?php
return [
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
        'development' => [
            'adapter' => 'mysql',
            'host' => 'db',
            'name' => 'event_manager',
            'user' => 'user',
            'pass' => 'password',
            'port' => '3306',
            'charset' => 'utf8',
        ],
    ],
];
