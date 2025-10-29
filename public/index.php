<?php

require_once __DIR__."/../src/config.php";
require_once __DIR__ . "/../src/helpers.php";
require_once ROOT."/vendor/autoload.php";

$app = new \Rum\Sandbox\Application();
require_once CONFIG.'/routes.php';

$app->run();


// TODO: библиотеку для работы с БД
// TODO: сделать класс CurlHandle
// TODO: создание констант из .env