<?php

ini_set('display_errors','1');
ini_set("max_execution_time", "240");
ini_set('date.timezone', 'Europe/Moscow');

const CFG_PATH     = DOCROOT . 'config' . DIRECTORY_SEPARATOR;
const ENG_PATH     = DOCROOT . 'engine' . DIRECTORY_SEPARATOR;
const ACT_PATH     = ENG_PATH . 'actions' . DIRECTORY_SEPARATOR;
const CLASS_PATH   = ENG_PATH . 'classes' . DIRECTORY_SEPARATOR;
const PUB_PATH     = DOCROOT . 'public' . DIRECTORY_SEPARATOR;
const VIEW_PATH    = DOCROOT . 'views' . DIRECTORY_SEPARATOR;
const LOG_PATH     = DOCROOT . 'logs' . DIRECTORY_SEPARATOR;
const PG_PATH      = VIEW_PATH . 'pages' . DIRECTORY_SEPARATOR;
const LAYOUTS_PATH = VIEW_PATH . 'layouts' . DIRECTORY_SEPARATOR;

const TITLE = 'Surf Coffee Panel';

require CFG_PATH   . 'DBconfig.php';
require CFG_PATH   . 'permissions.php';
require CFG_PATH   . 'questions.php';
require CLASS_PATH . 'DB.php';
require CLASS_PATH . 'Log.php';
require CLASS_PATH . 'User.php';
require CLASS_PATH . 'ArrayHelper.php';
require CLASS_PATH . 'Router.php';
require CLASS_PATH . 'PageHelper.php';