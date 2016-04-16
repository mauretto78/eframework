<?php

use Framework\Framework\WP\Enqueuer;

class WPTest extends \PHPUnit_Framework_TestCase
{
    protected $enq;

    public function setUp()
    {
        $this->enq = new Enqueuer();
    }

    public function testEnqueueSomeLoaders()
    {
        $this->enq->addScript('bootstrap');
        $this->enq->addStyle('bootstrap');

        $this->assertEquals(2, count($this->enq->getLoaders()));
    }
}