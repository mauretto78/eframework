<?php

namespace Framework\Framework\Mailer;

use Framework\Framework\Mailer;

/**
 * This interface is used both by MailerManager and by the adapter classes.
 *
 * The interface declares all methods of the adapters.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
interface MailerInterface
{
    /**
     * Configures the SMTP transport of the mailer.
     *
     * @param $smtp
     * @param $port
     * @param $username
     * @param $password
     * @param $encryption
     * @return mixed
     */
    public function configure($smtp, $port, $username, $password, $encryption = null);

    /**
     * Creates the message object.
     *
     * @param $msg
     */
    public function create($msg = null);

    /**
     * Sets the recipent(s) of the email.
     *
     * @param $to
     */
    public function setTo($to);

    /**
     * Sets the CC of the email.
     *
     * @param $cc
     */
    public function setCc($cc);

    /**
     * Sets the BCC of the email.
     *
     * @param $bcc
     */
    public function setBcc($bcc);

    /**
     * Sets the subject of the email.
     *
     * @param $subject
     */
    public function setSubject($subject);

    /**
     * Sets the From field of the email.
     *
     * @param $from
     */
    public function setFrom($from);

    /**
     * Sets the content of the email.
     *
     * @param $content
     */
    public function setBody($body, $contentType = 'text/html');

    /**
     * Sets the attachmeant of the email.
     *
     * @param $file
     */
    public function attach($file);

    /**
     * Sends out the message.
     *
     * @return mixed
     */
    public function send();
}
