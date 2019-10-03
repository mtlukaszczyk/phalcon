<?php

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);

if (\Whoops\Util\Misc::isAjaxRequest()) {
    $jsonHandler = new \Whoops\Handler\JsonResponseHandler();
    $jsonHandler->setJsonApi(true);
    $whoops->pushHandler($jsonHandler);
}

$whoops->register();

