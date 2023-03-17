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

$variables = ['pages' => $pages];

if ($user->getGroupSession() === 'ADMIN') {
    $reviews = DB::getAllReviews();
    $groupsVariables['reviews'] = $reviews;

    $variables = array_merge($variables, $groupsVariables);
} else {
    $spots = DB::getAllSpots();
    $groupsVariables['spots'] = $spots;

    $variables = array_merge($variables, $groupsVariables);
}

$content = $router->view($home, $variables);

require LAYOUTS_PATH . 'main.layout.php';