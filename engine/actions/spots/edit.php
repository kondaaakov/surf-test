<?php

use classes\Router;
use classes\User;

$router = new Router();
$user   = new User();

$id   = $router->getId();
$spot = DB::select('spots', '*', ['where' => ["id = $id"]]);
$spot = $spot[0];

if (!$spot) {
    $router->abort(404, 'Страница не найдена');
}

$title = "Редактировать Surf Coffee® x {$spot['name']}";

if (isset($_POST) && !empty($_POST)) {
    $newValues = [];
    foreach ($_POST as $key => $value) {
        if ($value != $spot[$key]) {
            $newValues[$key] = $value;
        }
    }

    if (!empty($newValues)) {
        DB::update('spots', $newValues, ["id" => $id]);
    }
    header("Location: /spots");
}

$cities = DB::select('spots_cities', 'spots_cities.id as id, concat(spots_countries.title_ru, ", ", spots_cities.title_ru) as text', [
    'join' => 'spots_countries on spots_cities.country_id = spots_countries.id'
]);

$content = $router->view('spots/form', ['cities' => $cities, 'spot' => $spot]);

require LAYOUTS_PATH . 'main.layout.php';