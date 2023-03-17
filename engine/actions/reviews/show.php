<?php

use classes\PageHelper;
use classes\Router;
use classes\User;

$router = new Router();
$user   = new User();
$pages  = new PageHelper();

$id     = $router->getId();
$review = DB::getOneReview($id);

if (!$review) {
    $router->abort(404, 'Страница не найдена');
}

$title = "Просмотр проверки #{$review['id']}";

$content = $router->view('reviews/show', ['review' => $review, 'pages' => $pages]);
require LAYOUTS_PATH . 'main.layout.php';