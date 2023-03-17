<?php

use classes\Router;

$router = new Router();
$id = $router->getId();
DB::delete('reviews', ['id' => $id]);
header("Location: /reviews");