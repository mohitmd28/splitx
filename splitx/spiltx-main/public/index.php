<?php

session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);

date_default_timezone_set('Asia/Kolkata');

const BASE_PATH = __DIR__ . '/../';

require BASE_PATH . 'vendor/autoload.php';
require BASE_PATH . 'bootstrap.php';

require BASE_PATH . 'Core/Router.php';

$uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$router = \Core\Router::load(BASE_PATH . 'routes.php')
    ->direct($uri, $method);

session()->unflash();
