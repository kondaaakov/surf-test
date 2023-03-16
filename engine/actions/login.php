<?php

use classes\ArrayHelper;
use classes\DB;
use classes\Router;
use classes\User;

$route  = new Router();
$arrays = new ArrayHelper();
$user   = new User();
$db     = new DB(DB_SETTINGS);

if (isset($_POST) && !empty($_POST)) {
    $user->authorization($_POST['mail'], $_POST['password']);
    header("Location: /");
}

$content = $route->view('login', []);

require LAYOUTS_PATH . 'login.layout.php';