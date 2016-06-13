<?php
// Load Kernel and return $app
require 'framework/bootstrap.php';

use Framework\Framework\WP\PostType\PostType;

// CPT
$cpt = new PostType('portfolio');
$cpt->setColumns(array(
    'Column 1' => 'val1',
    'Column 2' => 'val2',
    'Column 3' => 'val3',
    'Column 4' => 'val4',
    'Column 5' => array('callback' => 'testf'),
));

function testf()
{
    echo 'cavolo!';
}

// Nav menu
$nav = $app->container->get('Nav');
$nav->create('primary', 'Primary Navigation', 'website primary navigation menu.');

// Admin
require 'func/admin.php';
