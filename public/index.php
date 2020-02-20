<?php

use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->addRoutingMiddleware();

require('./home.php');

require('./read.php');

require('./advanced.php');

$app->run();
