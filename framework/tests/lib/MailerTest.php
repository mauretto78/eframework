<?php

use Framework\Framework\Mailer\MailerManager;
use Framework\Framework\Parameters;

class MailerTest extends PHPUnit_Framework_TestCase
{
    protected $m;

    public function setUp()
    {
        $this->m = new MailerManager('Swiftmailer');
    }

    public function testSwiftMailerSmtpTransportIsCorrectlyInstantiated()
    {
        $instance = $this->m->configure(Parameters::get('mailer.smtp'), Parameters::get('mailer.port'), Parameters::get('mailer.username'), Parameters::get('mailer.password'));

        $this->assertInstanceOf('\\Swift_SmtpTransport', $instance);
    }

    public function testSwiftMailerIsCorrectlyInstantiated()
    {
        $instance = $this->m->create();

        $this->assertInstanceOf('\\Swift_Message', $instance);
    }

    public function testSubjectIsCorrect()
    {
        $instance = $this->m->create('This is an awesome mail message');

        $this->assertEquals('This is an awesome mail message', $instance->getSubject());
    }

    public function testSendIsCorrect()
    {
        $transport = $this->m->configure(Parameters::get('mailer.smtp'), Parameters::get('mailer.port'), Parameters::get('mailer.username'), Parameters::get('mailer.password'), Parameters::get('mailer.encryption'));

        $message = $this->m->create();
        $message->setTo(array(
            'assistenza@easy-grafica.com' => 'Mauro Cassani',
            'mauretto1978@yahoo.it' => 'Mauretto',
        ));
        $message->setCc(array('another@fake.com' => 'Aurelio De Rosa'));
        $message->setBcc(array('boss@bank.com' => 'Bank Boss'));
        $message->setSubject('This email is sent using Swift Mailer');
        $message->setBody('You\'re our best client ever.');
        $message->setFrom('account@bank.com', 'Your bank');
        //$message->attach(\Swift_Attachment::fromPath(__DIR__.'/fixtures/mailer/dummy.txt'));

        //$this->assertEquals(4, $this->m->send());
    }
}
