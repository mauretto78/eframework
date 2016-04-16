<?php

// Load Eframework Kernel
require 'framework/app/bootstrap.php';

// Enqueue all the scripts and styles
$enq = $app->container->get('Enqueuer');
$enq->addAdminScript('admin-script', get_template_directory_uri() . '/js/admin.js', array(), '1.0.0', true);
$enq->addFrontendScript('front-end-script', get_template_directory_uri() . '/js/bootstrap.js', array(), '1.0.0', true);
$enq->addAdminStyle('admin-style', get_template_directory_uri(). '/css/admin.css', array(), '1.0.0', true);
$enq->addFrontendStyle('front-end-style', get_template_directory_uri(). '/css/app.css', array(), '1.0.0', true);
$enq->enqueue();