<?php


/**
 * This class is a simple wrapper of lessc class.
 *
 * The class declares a method to merge more less files into a single css output file.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
interface MailerInterface
{
    /**
     * Sets the subject of the email.
     *
     * @param $subject
     */
    public function setSubject($subject);

    /**
     * Sets the From field of the email.
     *
     * @param array
     */
    public function setFrom(array());

    /**
     * Sets the To field of the email.
     *
     * @param array
     */
    public function setTo(array());

    /**
     * Sets the content of the email.
     *
     * @param $content
     */
    public function setContent($content);

    /**
     * Sets the attachmeant of the email.
     *
     * @param $file
     */
    public function attach($file);

    /**
     * Sends out the message.
     *
     * @param $message
     * @return mixed
     */public function send($message);
}
