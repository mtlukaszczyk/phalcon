<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Session\Adapter\Files as Session;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Events\Event;

// Create a DI
$di = new FactoryDefault();

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

    $eventsManager->attach('dispatch:beforeDispatchLoop', function(Event $event, Dispatcher $dispatcher) {
        $params = $dispatcher->getParams();

        if (isset($params['language'])) {
            define('LANG_SYMBOL', $params['language']);
        } else {
            define('LANG_SYMBOL', 'de');
        }

        unset($params['language']);
        $dispatcher->setParams($params);

        return $dispatcher;
    });

    $eventsManager->attach("dispatch", function($event, $dispatcher) {
        $actionName = Phalcon\Text::camelize($dispatcher->getActionName());
        $controllerName = Phalcon\Text::camelize($dispatcher->getControllerName());
        $dispatcher->setActionName(lcfirst($actionName));
        $dispatcher->setControllerName($controllerName);

        return $dispatcher;
    });


    $dispatcher = new Dispatcher();

    $dispatcher->setDefaultNamespace(
            'App\Controllers'
    );

    // Assign the events manager to the dispatcher
    $dispatcher->setEventsManager($eventsManager);

    return $dispatcher;
});
