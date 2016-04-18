<?php

use Framework\Framework\Session\SessionBridge;

class SessionTest extends PHPUnit_Framework_TestCase
{
    protected $session;

    public function setUp()
    {
        $this->session = new SessionBridge();
    }

    public function testIfSessionWorks()
    {
        $session = $this->session->getSession();
        $session->setId(12345678);
        $session->setName('dummySession');
        $session->set('key', 'valueOfKeySession');

        $this->assertEquals($session->getId(), 12345678);
        $this->assertEquals($session->getName(), 'dummySession');
        $this->assertEquals($session->get('key'), 'valueOfKeySession');
    }
}
