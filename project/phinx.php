<?php

define('APP_VERSION', 'local');

require __DIR__ . '/app/config/' . APP_VERSION . '/config.php';
require __DIR__ . '/app/migrations/Migration.php';

return [
    'paths' => [
        'migrations' => 'app/migrations'
    ],
    'migration_base_class' => '\App\Migrations\Migration',
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_database' => 'dev',
        'dev' => [
            'adapter' => CONFIG['DATABASE']['driver'],
            'host' => CONFIG['DATABASE']['host'],
            'name' => CONFIG['DATABASE']['database'],
            'user' => CONFIG['DATABASE']['username'],
            'pass' => CONFIG['DATABASE']['password']
        ]
    ]
];


// creating migration: php vendor/bin/phinx create MIGRATIONNAME -c phinx.php
// running migration: php vendor/bin/phinx migrate -c phinx.php
// eloquent migrations doc: https://laravel.com/docs/5.8/migrations