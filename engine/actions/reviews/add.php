<?php

use classes\Router;
use classes\User;

$router = new Router();
$user   = new User();

$id   = $router->getId();
$spot = DB::getOneSpot($id);

if (!$spot) {
    $router->abort(404, 'Страница не найдена');
}

$title = "Проверка Surf Coffee® x {$spot['name']}";

if (isset($_POST) && !empty($_POST)) {
    DB::insert('reviews', $_POST);

    header("Location: /");
}

$content = $router->view('reviews/form', ['spot' => $spot, 'userId' => $user->getIdSession()]);

require LAYOUTS_PATH . 'main.layout.php';