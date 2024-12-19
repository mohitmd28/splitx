<?php

use Core\{App, Container, Session, Validator};
use Core\Database\{Connection, Builder};

define('APP_DIR', str_replace('\\', '/', __DIR__));
define('VIEW_DIR', APP_DIR . '/view');

$container = new Container();

$container->bind('Core\Database\Connection', function () {
    return new Connection;
});

$container->bind('Core\Database\Builder', function () {
    return new Builder(App::resolve('Core\Database\Connection'));
});

$container->bind('Core\Session', function () {
    return new Session();
});

$container->bind('Core\Validator', function () {
    return new Validator();
});

App::setContainer($container);
