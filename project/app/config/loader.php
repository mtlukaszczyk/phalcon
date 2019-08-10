<?php

use Phalcon\Loader;

// Register an autoloader
$loader = new Loader();

$loader->registerDirs(
        [
            APP_PATH . '/controllers/',
            APP_PATH . '/plugins/'
        ]
);

$loader->registerNamespaces(
        [
            'App\Classes' => '../app/classes/',
            'App\Helpers' => '../app/helpers/',
            'App\Models' => '../app/models/',
            'App\Controllers' => '../app/controllers/',
        ]
);


$loader->register();
