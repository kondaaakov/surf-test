<?php

use classes\Router;
use classes\User;

$router = new Router();
$user   = new User();

$id     = $router->getId();
$review = DB::select('reviews', '*', ['where' => ["id = $id"]]);
$review = $review[0];

if (!$review) {
    $router->abort(404, 'Страница не найдена');
}

$title = "Редактировать проверку #{$review['id']}";

$spots = DB::getAllSpotsForSelect();

if (isset($_POST) && !empty($_POST)) {
    $newValues = [];
    foreach ($_POST as $key => $value) {
        if ($value != $review[$key]) {
            $newValues[$key] = $value;
        }
    }

    if (!empty($newValues)) {
        DB::update('reviews', $newValues, ["id" => $id]);
    }
    header("Location: /reviews");
}

$content = $router->view('reviews/form', ['review' => $review, 'spots' => $spots,  'userId' => $user->getIdSession()]);

require LAYOUTS_PATH . 'main.layout.php';