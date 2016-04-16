<?php

namespace Framework\Framework\Mailer\SwiftMailer;

/**
 * This class is a simple wrapper of Swiftmailer class.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class SwiftmailerService
{
    private $transport;
    private $instance;

    public function configure($smtp, $port, $username, $password, $encryption = null)
    {
        $transport = \Swift_SmtpTransport::newInstance($smtp, $port, $encryption);
        $transport->setUsername($username);
        $transport->setPassword($password);

        return $this->transport = $transport;
    }

    public function create($msg = null)
    {
        return $this->instance = \Swift_Message::newInstance($msg);
    }

    public function setTo($to)
    {
        $this->instance->setTo($to);
    }

    public function setCc($cc)
    {
        $this->instance->setCc($cc);
    }

    public function setBcc($bbc)
    {
        $this->instance->setBcc($bbc);
    }

    public function setSubject($subject)
    {
        $this->instance->setSubject($subject);
    }

    public function setBody($body, $contentType = 'text/html')
    {
        $this->instance->setBody($body, $contentType);
    }

    public function attach($file)
    {
        $this->instance->attach(\Swift_Attachment::fromPath($file));
    }

    public function send()
    {
        $mailer = \Swift_Mailer::newInstance($this->transport);
        return $mailer->send($this->instance);
    }
}
