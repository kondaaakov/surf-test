<?php

use classes\Router;
use classes\ArrayHelper;
use classes\User;

const DOCROOT = __DIR__ . DIRECTORY_SEPARATOR;
require 'config/settings.php';

session_start([
    'cookie_lifetime' => 86400,
]);


DB::config(DB_SETTINGS['host'], DB_SETTINGS['port'], DB_SETTINGS['user'], DB_SETTINGS['password'], DB_SETTINGS['name']);

$arrays = new ArrayHelper();
$route  = new Router();
$user   = new User();

if($user->isAuth()) {
    $route->route('home');
} else {
    $route->route('login');
}

