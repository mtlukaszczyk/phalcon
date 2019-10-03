<?php

use Phalcon\Mvc\View;

$di->set('view', function () {
    $view = new View();
    $view->setViewsDir('../app/views/');
    $view->registerEngines([
        App\Classes\Engines\Twig::DEFAULT_EXTENSION => function ($view, $di) {
            $twigEngine = new App\Classes\Engines\Twig($view, $di, [
                'cache' => false,
            ]);

            $twigEngine->prepareFunctions($di);

            return $twigEngine;
        },
        App\Classes\Engines\Volt::DEFAULT_EXTENSION => function ($view, $di) {
            $voltEngine = new App\Classes\Engines\Volt($view, $di);

            $voltEngine->prepareFunctions($di);

            return $voltEngine;
        }
    ]);


    return $view;
});
