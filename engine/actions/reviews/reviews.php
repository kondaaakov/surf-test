<?php

use classes\PageHelper;
use classes\Router;
use classes\User;

$router = new Router();
$user   = new User();
$pages  = new PageHelper();


$title = "Проверки";

if ($user->getGroupSession() === 'ADMIN') {
    $reviews = DB::getAllReviews();
} else {
    $reviews = DB::getReviewsByUser($user->getIdSession());
}

$content = $router->view('reviews/reviews', ['user' => $user, 'reviews' => $reviews, 'pages' => $pages]);

require LAYOUTS_PATH . 'main.layout.php';