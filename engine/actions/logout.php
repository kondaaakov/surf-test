<?php

use classes\Router;

$router = new Router();

unset($_SESSION['user']);
header("Location: /");