<?php

use classes\Router;
use classes\User;

$router = new Router();
$user   = new User();

$title = 'Кофейни';

$spots = DB::select('spots', 'spots.*, spots_cities.title_ru AS city, spots_countries.title_ru AS country', [
    'join' => 'spots_cities ON spots_cities.id = spots.city_id LEFT JOIN spots_countries ON spots_countries.id = spots_cities.country_id'
]);

$content = $router->view('spots/spots', ['spots' => $spots]);

require LAYOUTS_PATH . 'main.layout.php';