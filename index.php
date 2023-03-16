<?php

use classes\Router;
use classes\ArrayHelper;
use classes\DB;
use classes\User;

const DOCROOT = __DIR__ . DIRECTORY_SEPARATOR;
require 'config/settings.php';

session_start([
    'cookie_lifetime' => 86400,
]);

$db     = new DB(DB_SETTINGS);
$arrays = new ArrayHelper();
$route  = new Router();
$user   = new User();

if($user->isAuth()) {
    $route->route('home');
} else {
    $route->route('login');
}

