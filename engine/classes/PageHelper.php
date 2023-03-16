<?php

namespace classes;

class PageHelper {

    private User $user;

    public function __construct() {
        $this->user = new User();
    }

    public function welcomeMessage() : string {
        $name = $this->user->getNameSession();

        return "<h1 class='hello-message'>Привет, $name!</h1>";
    }

}