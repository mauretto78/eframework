<?php
/**
 * Eframework Bootstrap file
 *
 * @var ContainerBuilder
 * @return $app
 */

use Framework\Kernel\AppKernel;

require __DIR__.'/../vendor/autoload.php';

$app = new AppKernel(new DI\ContainerBuilder());
$app->setConfigFile(__DIR__.'/../config/config.php');
$app->setEnvironment('dev');
$app->load();

return $app;
