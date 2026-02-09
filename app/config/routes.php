<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);


use flight\Engine;
use flight\net\Router;

/**
 * @var Router $router
 * @var Engine $app
 */

Flight::route('/', function () {
    Flight::render('login');
});