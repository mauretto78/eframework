<?php

use Framework\App;

require __DIR__.'/vendor/autoload.php';

// Runs the App in 'dev' environment.
$app = new App('dev');

// return Request and Session
$request = $app->container->get('Request');
$session = $app->container->get('Session');
