<?php

use Framework\Framework\WP\Widget;

// register sidebar
Widget::registerSidebar(array(
    'name' => __( 'Claim area'),
    'id' => 'claim',
    'description' => __( 'Trascina Widgets in quest\'area.' ),
    'before_title' => '',
    'after_title' => '',
    'before_widget' => '',
    'after_widget'  => ''
));