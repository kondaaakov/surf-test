<?php

namespace classes;

use DB;

class PageHelper {

    private User $user;

    public function __construct() {
        $this->user = new User();
    }

    public function welcomeMessage() : string {
        $name = $this->user->getNameSession();

        return "<h1 class='hello-message'>Привет, $name!</h1>";
    }

    public function welcomeMessageInspector() : string {
        $name = $this->user->getNameSession();

        return "<h1 class='hello-message'>Привет, $name! Начнём проверку?</h1>";
    }

    public function normalizeDate($date) : string {
        if (empty($date)) {
            return 'Нет данных';
        }

        $date = new \DateTime($date);

        return $date->format("d.m.Y H:i");
    }

    public function normalizeAvg($float) : float {
        return round($float, 1);
    }

    public function averageElement($spotId, $custom = null) : string {

        $avgSpot = $custom === null ? DB::getAvgSpot($spotId) : $custom;
        $avgSpot = round($avgSpot, 2);

        if ($avgSpot == 0) {
            $class = 'avg-null';
        } else if ($avgSpot > 0 && $avgSpot < 3) {
            $class = 'avg-red';
        } else if ($avgSpot < 4.5) {
            $class = 'avg-yellow';
        } else {
            $class = 'avg-green';
        }

        return "<span class='avg-spot $class'>$avgSpot</span>";
    }

}