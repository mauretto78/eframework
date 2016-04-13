<?php

use Framework\Framework\Mailer\Mailer;

class MailerTest extends PHPUnit_Framework_TestCase
{
    protected $m;

    public function setUp()
    {
        $this->m = new Mailer(new MailerInterface);
    }

    public function testSendOk()
    {
        $this->m->setSubject('Your subject');
        $this->m->setFrom(array('john@doe.com' => 'John Doe'));
        $this->m->setTo(array('receiver@domain.org', 'other@domain.org' => 'A name'));
        $this->m->setContent(__DIR__.'/fixtures/mailer/body.php');
        $this->m->attach(Swift_Attachment::fromPath(__DIR__.'/fixtures/mailer/my-document.pdf'));

        $this->assertTrue($this->m->send());
    }
}
