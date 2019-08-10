<?php

use Phalcon\Mvc\View;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Session\Adapter\Files as Session;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Events\Manager as EventsManager;

// Create a DI
$di = new FactoryDefault();

$di->set('view', function () {
    $view = new View();
    $view->setViewsDir('../app/views/');
    $view->registerEngines([
        App\Classes\Twig::DEFAULT_EXTENSION => function ($view, $di) {

            $twigEngine = new App\Classes\Twig($view, $di, [
                'cache' => false,
            ]);

            $twigEngine->prepareFunctions($di);

            return $twigEngine;
        }
    ]);

    return $view;
});

// Setup a base URI

$di->set('url', function () {
    $url = new UrlProvider();
    $url->setBaseUri('/');
    return $url;
});

// Setup session

$di->setShared('session', function () {
    $session = new Session();

    $session->start();

    return $session;
});

$di->set('dispatcher', function () {
    // Create an events manager
    $eventsManager = new EventsManager();

    // Listen for events produced in the dispatcher using the Security plugin
    $eventsManager->attach(
            'dispatch:beforeExecuteRoute', new SecurityPlugin()
    );

    // Handle exceptions and not-found exceptions using NotFoundPlugin
    $eventsManager->attach(
            'dispatch:beforeException', new NotFoundPlugin()
    );

    $dispatcher = new Dispatcher();

    $dispatcher->setDefaultNamespace(
            'App\Controllers'
    );

    // Assign the events manager to the dispatcher
    $dispatcher->setEventsManager($eventsManager);

    return $dispatcher;
});
