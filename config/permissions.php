<?php

const PERMISSIONS = [
    'NO_USER'   => ['login'],
    'ADMIN'     => ['home', 'spots', 'users', 'logout', 'reviews'],
    'INSPECTOR' => ['home', 'logout', 'reviews']
];