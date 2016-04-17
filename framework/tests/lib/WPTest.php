<?php

use Framework\Framework\WP\Enqueuer;
use Framework\Framework\WP\Path;

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
        $this->enq->addAdminScript('admin-script', Path::template('/js/admin.js'), array(), '1.0.0', true);
        $this->enq->addFrontendScript('front-end-script', Path::template('/js/bootstrap.js'), array(), '1.0.0', true);
        $this->enq->addAdminStyle('admin-style', Path::template('/css/admin.css'), array(), '1.0.0', true);
        $this->enq->addFrontendStyle('front-end-style', Path::template('/css/app.css'), array(), '1.0.0', true);

        $this->assertEquals(2, count($this->enq->getAdminFiles()));
        $this->assertEquals(2, count($this->enq->getFrontendFiles()));
        $this->assertTrue($this->enq->enqueue());
    }
}
