<?php

use Framework\Framework\Mailer\MailerManager;
use Symfony\Component\Yaml\Yaml;

class MailerTest extends PHPUnit_Framework_TestCase
{
    protected $m;

    public function setUp()
    {
        $this->m = new MailerManager('Swiftmailer');
    }

    public function testSwiftMailerSmtpTransportIsCorrectlyInstantiated()
    {
        $config = Yaml::parse(file_get_contents(__DIR__.'/../../config/parameters.yml'));
        $instance = $this->m->configure($config['mailer.smtp'], $config['mailer.port'], $config['mailer.username'], $config['mailer.password']);

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
        $config = Yaml::parse(file_get_contents(__DIR__.'/../../config/parameters.yml'));
        $transport = $this->m->configure($config['mailer.smtp'], $config['mailer.port'], $config['mailer.username'], $config['mailer.password'], $config['mailer.encryption']);

        $message = $this->m->create();
        $message->setTo(array(
            'assistenza@easy-grafica.com' => 'Mauro Cassani',
            'mauretto1978@yahoo.it' => 'Mauretto'
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
