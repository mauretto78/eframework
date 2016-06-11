<?php

use Framework\App;

require __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/../../../../wp-load.php'; // Load Worpdress

// Runs the App in 'dev' environment.
$app = new App('dev');

// return Request Session
$request = $app->container->get('Session')->getRequest();
$session = $app->container->get('Session')->getSession();
