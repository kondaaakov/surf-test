<?php

use classes\Router;

$router = new Router();
$id = $router->getId();
DB::delete('users', ['id' => $id]);
header("Location: /users");