<?php
// Load Kernel and return $app
require 'framework/bootstrap.php';

//Loading Custom function
$childTheme = $path::childDir('/inc/custom-functions.php');
include $childTheme;
