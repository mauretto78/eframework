<?php

use Framework\App;

require __DIR__.'/../vendor/autoload.php';

/*
 * Runs the App in 'dev' environment.
 */
$app = new App('dev');

return $app;
