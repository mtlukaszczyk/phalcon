<?php

use Phalcon\Mvc\Router;

$di->set('router', function () {

    $router = new Router(false);

    $router->add('/{language:[a-z]{2}}/:controller/:action/:params/', [
        'language' => 1,
        'controller' => 2,
        'action' => 3,
        'params' => 4
    ]);

    $router->add('/{language:[a-z]{2}}/:controller/:action/', [
        'language' => 1,
        'controller' => 2,
        'action' => 3
    ]);

    $router->add('/{language:[a-z]{2}}/:controller/', [
        'language' => 1,
        'controller' => 2,
        'action' => 'index'
    ]);

    $router->add('/{language:[a-z]{2}}/', [
        'language' => 1,
        'controller' => 'index',
        'action' => 'index',
    ]);

    $router->add('/', [
        'controller' => 'index',
        'action' => 'index',
    ]);

    return $router;
});
