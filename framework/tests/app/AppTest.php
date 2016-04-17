<?php

use Framework\App;

class AppTest extends PHPUnit_Framework_TestCase
{
    protected $app;

    public function setUp()
    {
        $this->app = new App('dev');
    }

    public function testIfAllServicesCanBeLoadedCorrectly()
    {
        $baseForm = $this->app->container->get('BaseForm');
        $bootstrapForm = $this->app->container->get('BootstrapForm');
        $enq = $this->app->container->get('Enqueuer');
        $lessify = $this->app->container->get('Lessify');
        $mailer = $this->app->container->get('Mailer');
        $request = $this->app->container->get('Request');
        $session = $this->app->container->get('Session');
        $sluggify = $this->app->container->get('Sluggify');
        $validator = $this->app->container->get('Validator');

        $this->assertInstanceOf('\Framework\Framework\Form\BaseForm', $baseForm);
        $this->assertInstanceOf('\Framework\Framework\Form\BootstrapForm', $bootstrapForm);
        $this->assertInstanceOf('\Framework\Framework\WP\Enqueuer', $enq);
        $this->assertInstanceOf('\Framework\Framework\Lessify', $lessify);
        $this->assertInstanceOf('\Framework\Framework\Mailer\MailerManager', $mailer);
        $this->assertInstanceOf('\Symfony\Component\HttpFoundation\Request', $request);
        $this->assertInstanceOf('\Symfony\Component\HttpFoundation\Session\Session', $session);
        $this->assertInstanceOf('\Framework\Framework\Sluggify', $sluggify);
        $this->assertInstanceOf('\Framework\Framework\Validator\Validator', $validator);
    }
}
