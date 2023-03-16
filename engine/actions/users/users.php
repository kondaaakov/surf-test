<?php

use classes\Router;
use classes\User;

$router = new Router();
$user   = new User();

$title = 'Пользователи';

$users = DB::select('users', 'users.*, users_groups.code as group_code, users_groups.title as title', [
    'join' => 'users_groups ON users_groups.id = users.group_id'
]);

$content = $router->view('users/users', ['users' => $users]);

require LAYOUTS_PATH . 'main.layout.php';