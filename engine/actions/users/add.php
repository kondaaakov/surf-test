<?php

use classes\Router;
use classes\User;

$router = new Router();
$user   = new User();


if (isset($_POST) && !empty($_POST)) {
    $newUser = [];
    foreach ($_POST as $item => $value) {
        $newUser[$item] = $item === 'password' ? password_hash($value, PASSWORD_DEFAULT) : $value;
    }

    DB::insert('users', $newUser);
    header("Location: /users");
}

$title = 'Добавить пользователя';

$groups = DB::select('users_groups', 'id, concat(title, " (", code, ")") as text');

$content = $router->view('users/form', ['groups' => $groups]);

require LAYOUTS_PATH . 'main.layout.php';