<?php

namespace Framework\Framework\Mailer\SwiftMailer;

use Framework\Framework\Mailer\MailerInterface;
use Framework\Framework\Mailer\SwiftMailer\SwiftmailerService;

/**
 * This class is a simple wrapper of lessc class.
 *
 * The class declares a method to merge more less files into a single css output file.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class SwiftmailerAdapter implements MailerInterface
{
    private $mailer;

    public function __construct(SwiftmailerService $mailer)
    {
        $this->mailer = $mailer;
    }

    public function configure($smtp, $port, $username, $password, $encryption = null)
    {
        return $this->mailer->configure($smtp, $port, $username, $password, $encryption);
    }

    public function create($msg = null)
    {
        return $this->mailer->create($msg);
    }

    public function setTo($to)
    {
        return $this->mailer->setTo($to);
    }

    public function setCc($cc)
    {
        return $this->mailer->setCc($cc);
    }

    public function setBcc($bcc)
    {
        return $this->mailer->setBcc($bcc);
    }

    public function setSubject($subject)
    {
        return $this->mailer->setSubject($subject);
    }

    public function setFrom($from)
    {
        return $this->mailer->setFrom($from);
    }

    public function setBody($body, $contentType = 'text/html')
    {
        return $this->mailer->setBody($body, $contentType);
    }

    public function attach($file)
    {
        return $this->mailer->attach($file);
    }

    public function send()
    {
        return $this->mailer->send();
    }
}
