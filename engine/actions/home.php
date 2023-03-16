<?php

use classes\ArrayHelper;
use classes\PageHelper;
use classes\Router;
use classes\User;

$router = new Router();
$arrays = new ArrayHelper();
$pages  = new PageHelper();
$user   = new User();

$home  = $user->getGroupSession() === 'ADMIN' ? 'home.admin' : 'home.user';
$title = 'Главная';

$content = $router->view($home, ['pages' => $pages]);

require LAYOUTS_PATH . 'main.layout.php';