<?php

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