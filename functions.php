<?php

// 1. Load Eframework Kernel
require 'framework/app/bootstrap.php';

$lessc = $app->container->get('lessc');

$lessc->setFormatter("compressed");
$lessc->compileFile("test.less","test.css");
