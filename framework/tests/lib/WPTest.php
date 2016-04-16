<?php

use Framework\Framework\WP\Enqueuer;

require_once __DIR__.'/../../../../../../wp-load.php'; // Worpdress

class WPTest extends \PHPUnit_Framework_TestCase
{
    protected $enq;

    public function setUp()
    {
        $this->enq = new Enqueuer();
    }

    public function testEnqueueSomeFiles()
    {
        $this->enq->addAdminScript('admin-script', get_template_directory_uri().'/js/admin.js', array(), '1.0.0', true);
        $this->enq->addFrontendScript('front-end-script', get_template_directory_uri().'/js/bootstrap.js', array(), '1.0.0', true);
        $this->enq->addAdminStyle('admin-style', get_template_directory_uri().'/css/admin.css', array(), '1.0.0', true);
        $this->enq->addFrontendStyle('front-end-style', get_template_directory_uri().'/css/app.css', array(), '1.0.0', true);

        $this->assertEquals(2, count($this->enq->getAdminFiles()));
        $this->assertEquals(2, count($this->enq->getFrontendFiles()));
        $this->assertTrue($this->enq->enqueue());
    }
}
