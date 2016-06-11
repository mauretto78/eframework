<?php

use Framework\Framework\Session\SessionBridge;

class SessionTest extends PHPUnit_Framework_TestCase
{
    protected $session;

    public function setUp()
    {
        $this->session = new SessionBridge();
    }

    public function testIfSessionSetWorks()
    {
        $session = $this->session->getSession();
        $session->set('key', 'valueOfKeySession');

        $this->assertEquals($session->get('key'), 'valueOfKeySession');
    }
}
