<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

use Phalcon\Mvc\Application;

// Define some absolute path constants to aid in locating resources
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create('..');
$dotenv->load();

require __DIR__ . "/../app/config/loader.php";
require __DIR__ . "/../app/config/whoops.php";
require __DIR__ . "/../app/config/services.php";
require __DIR__ . "/../app/config/view.php";
require __DIR__ . "/../app/config/eloquent.php";
require __DIR__ . "/../app/config/router.php";

$application = new Application($di);

$response = $application->handle();
$response->send();
