<?php

// Load Eframework Kernel
require 'framework/bootstrap.php';

use Framework\Framework\WP\Admin\Admin;
use Framework\Framework\WP\Admin\AdminPage;
use Framework\Framework\WP\Enqueuer;
use Framework\Framework\WP\Path;

// enqueue styles
$e = new Enqueuer();
$e->addAdminStyle('font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css', array(), '4.6.1', 'all');
$e->addAdminStyle('framework-style', Path::template('/framework/admin/css/framework.css'), array(), '1.0.0', 'all');
$e->enqueue();

// admin pages
$admin = new Admin();
$admin->addPage(new AdminPage('eframework','E-Framework','edit_themes','base.php'));
$admin->addPage(new AdminPage('eframework','E-Framework','edit_themes','base.php'));
