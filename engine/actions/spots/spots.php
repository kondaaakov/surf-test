<?php

use classes\PageHelper;
use classes\Router;
use classes\User;

$router = new Router();
$user   = new User();
$pages  = new PageHelper();

if (isset($_GET['by_spot']) && !empty($_GET['by_spot'])) {
    $spot = DB::getOneSpot($_GET['by_spot']);
    $title = "Спот Surf Coffee® x {$spot['name']}";

    $reviews = DB::getReviewsBySpot($spot['id']);
    $spots = DB::getAllSpotsForSelect();

    $content = $router->view('spots/spot', ['spot' => $spot, 'spots' => $spots, 'reviews' => $reviews, 'pages' => $pages]);
} else {
    $title = 'Кофейни';
    $spots = DB::getAllSpots();

    $content = $router->view('spots/spots', ['spots' => $spots, 'pages' => $pages]);
}



require LAYOUTS_PATH . 'main.layout.php';