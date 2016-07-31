<?php

use Framework\App;
use Framework\Framework\WP\Action;

require __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/../../../../wp-load.php'; // Load Worpdress

// Runs the App in 'dev' environment.
$app = new App('dev');

// Return Action instance
$action = Action::getInstance();

// Return Path instance
$path = $app->container->get('Path');

// Return Query instance
$query = $app->container->get('Query');

// Return Request Session instance
$request = $app->container->get('Session')->getRequest();
$session = $app->container->get('Session')->getSession();

// Return Theme instance
$theme = $app->container->get('Theme');
