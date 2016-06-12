<?php
// Load Eframework Kernel
// and return $app
require 'framework/bootstrap.php';

use Framework\Framework\WP\Admin\AdminPage;
use Framework\Framework\WP\Path;
use Framework\Framework\WP\Action;
use Framework\Framework\WP\Ajax;
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

// Enqueue styles
$google_fonts_args = array(
    'family' => 'Lato:400,700',
    'subset' => 'latin,latin-ext',
);
$e = $app->container->get('Enqueuer');
$e->addAdminStyle('font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css', array(), '4.6.1', 'all');
$e->addAdminStyle('google_fonts', add_query_arg($google_fonts_args, '//fonts.googleapis.com/css'), array(), null);
$e->addAdminStyle('framework-style', Path::template('/framework/admin/css/framework.css'), array(), '1.0.0', 'all');
$e->addAdminScript('media-upload-js', Path::template('/framework/admin/js/admin-media-upload.js'), array('jquery'), '1.0.0', true);
$e->addAdminScript('ace-editor-js', Path::template('/framework/admin/assets/ace/src/ace.js'), array('jquery'), '1.0.0', true);
$e->addAdminScript('jscolor', Path::template('/framework/admin/assets/jscolor/jscolor.min.js'), array('jquery'), '1.0.0', true);
$e->addAdminScript('ajax-process-js', Path::template('/framework/admin/ajax/ajax-process.js'), array('jquery'), null, true);
$e->addAdminScript('media-upload-js', Path::template('/framework/admin/js/admin-media-upload.js'), array('jquery'), '1.0.0', true);
$e->addAdminScript('framework-js', Path::template('/framework/admin/js/framework.js'), array('jquery'), '1.0.0', true);
$e->enqueue();

// Admin pages
$admin = $app->container->get('Admin');
$admin->addPage(new AdminPage('eframework', 'E-Framework', 'edit_themes', 'layout.php'));

// Admin ajax handle request
function pw_load_scripts()
{
    wp_localize_script('ajax-process-js', 'AjaxProcess', array(
        'ajaxurl' => Path::admin('admin-ajax.php'),
        'success' => 'Data successfully saved.',
        'error' => 'Error saving data.',
    ));
}

function process($section)
{
    $ajax = new Ajax($section);
    $ajax->handle();
}

$action = Action::getInstance();
$action->add('admin_enqueue_scripts', 'pw_load_scripts');
$action->add('wp_ajax_general', call_user_func_array('process', array('section' => 'general')));
$action->add('wp_ajax_colors', call_user_func_array('process', array('section' => 'colors')));
$action->add('wp_ajax_slider', call_user_func_array('process', array('section' => 'slider')));
$action->add('wp_ajax_blog', call_user_func_array('process', array('section' => 'blog')));
$action->add('wp_ajax_mail_settings', call_user_func_array('process', array('section' => 'mail_settings')));
$action->add('wp_ajax_css', call_user_func_array('process', array('section' => 'css')));
$action->add('wp_ajax_social', call_user_func_array('process', array('section' => 'social')));

// support
$support = $app->container->get('Support');
$support->add('post-thumbnails');
$support->add('post-formats', array('aside', 'gallery'));
