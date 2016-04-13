<?php

namespace Framework\Framework\Mailer;

use MailerInterface;

/**
 * This class is a simple Mailer wrapper class.
 *
 * The class declares a method to merge more less files into a single css output file.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Mailer
{
    private $mailer;

    /**
     * Mailer constructor.
     * @param MailerInterface $mailer
     */
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }
}
