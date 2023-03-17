<?php

use classes\Router;
use classes\User;

$router = new Router();
$user   = new User();

$id     = $router->getId();
$userDB = DB::select('users', '*', ['where' => ["id = $id"]]);
$userDB = $userDB[0];

if (!$userDB) {
    $router->abort(404, 'Страница не найдена');
}

if (isset($_POST) && !empty($_POST)) {
    $newValues = [];
    foreach ($_POST as $key => $value) {
        if ($key === 'password') {
            if (empty($value)) {
                continue;
            } else {
                $newPassword = password_hash($value, PASSWORD_DEFAULT);
                $newValues[$key] = $newPassword;
            }
        } else if ($value != $userDB[$key]) {
            $newValues[$key] = $value;
        }
    }

    if (!empty($newValues)) {
        DB::update('users', $newValues, ["id" => $id]);
    }
    header("Location: /users");
}

$title = "Редактировать пользователя {$userDB['name']}";


$groups = DB::select('users_groups', 'id, concat(title, " (", code, ")") as text');

$content = $router->view('users/form', ['groups' => $groups, 'userDB' => $userDB]);

require LAYOUTS_PATH . 'main.layout.php';