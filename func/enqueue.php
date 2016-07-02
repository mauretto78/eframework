<?php

use Framework\Framework\WP\Path;

$google_fonts_args = array(
    'family' => 'Montserrat:400,700|Source+Sans+Pro:400',
    'subset' => 'latin,latin-ext',
);

$e = $app->container->get('Enqueuer');
$e->addFrontendStyle('bootstrap-css', Path::child('/assets/bootstrap-3.3.6-dist/css/bootstrap.min.css'), array(), '3.3.6', true);
$e->addFrontendStyle('fontawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css', array(), '4.6.3', true);
$e->addFrontendStyle('google_fonts', add_query_arg($google_fonts_args, '//fonts.googleapis.com/css'), array(), null);
$e->addFrontendStyle('showup-style', Path::child('/assets/showup/showup.css'), array(), '1.0.0', true);
$e->addFrontendStyle('front-end-main-style', Path::child('/css/app.css'), array(), '1.0.0', true);
$e->addFrontendScript('jquery-lastest', '/wp-includes/js/jquery/jquery.js', array(), '1.11.0', true);
$e->addFrontendScript('bootstrap-script', Path::child('/assets/bootstrap-3.3.6-dist/js/bootstrap.min.js'), array(), '1.0.0', true);
$e->addFrontendScript('showup-script', Path::child('/assets/showup/showup.js'), array('jquery-lastest'), '1.0.0', true);
$e->addFrontendScript('retinajs-script', Path::child('/assets/retinajs-2.0.0/retina.js'), array(), '2.0.0', true);
$e->addFrontendScript('front-end-main-script', Path::child('/js/app.js'), array('jquery-lastest'), '3.3.6', true);
$e->enqueue();
