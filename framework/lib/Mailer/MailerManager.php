<?php

namespace Framework\Framework\Mailer;

use Framework\Framework\Mailer\SwiftMailer\SwiftmailerAdapter;
use Framework\Framework\Mailer\SwiftMailer\SwiftmailerService;

/**
 * This class is a Mailer manager class.
 *
 * The class instantiates the called adapter.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class MailerManager implements MailerInterface
{
    /**
     * The instance of the called adapter.
     *
     * @var object $mailer
     */
    private $adapter;

    /**
     * MailerManager constructor.
     * @param $adapter
     */
    public function __construct($adapter)
    {
        switch($adapter){
            case 'Swiftmailer':
                $this->adapter = new SwiftmailerAdapter(new SwiftmailerService());
                break;

            default:
                throw new \Exception("No adapter class found.");
                break;
        }
    }

    public function configure($smtp, $port, $username, $password, $encryption = null)
    {
        return $this->adapter->configure($smtp, $port, $username, $password, $encryption);
    }

    public function create($msg = null)
    {
        return $this->adapter->create($msg);
    }

    public function setTo($to)
    {
        return $this->adapter->setTo($to);
    }

    public function setCc($cc)
    {
        return $this->adapter->setCc($cc);
    }

    public function setBcc($bcc)
    {
        return $this->adapter->setBcc($bcc);
    }

    public function setSubject($subject)
    {
        return $this->adapter->setSubject($subject);
    }

    public function setFrom($from)
    {
        return $this->adapter->setFrom($from);
    }

    public function setBody($body, $contentType = 'text/html')
    {
        return $this->adapter->setBody($body, $contentType);
    }

    public function attach($file)
    {
        return $this->adapter->attach($file);
    }

    public function send()
    {
        return $this->adapter->send();
    }
}
