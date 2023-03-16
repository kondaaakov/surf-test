<?php

use classes\DB;
use classes\Router;
use classes\User;

$router = new Router();
$user   = new User();
$db     = new DB(DB_SETTINGS);


if (isset($_POST) && !empty($_POST)) {
    $db->create('spots', $_POST);
    header("Location: /spots");
}

$title = 'Добавить кофейню';

$cities = $db->get('spots_cities', 'spots_cities.id as id, concat(spots_countries.title_ru, ", ", spots_cities.title_ru) as text', [
    'join' => 'spots_countries on spots_cities.country_id = spots_countries.id'
]);

$content = $router->view('spots/add', ['cities' => $cities]);

require LAYOUTS_PATH . 'main.layout.php';