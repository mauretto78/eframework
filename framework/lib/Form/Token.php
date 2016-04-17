<?php

namespace Framework\Framework\Form;

use Symfony\Component\HttpFoundation\Session\Session;

/**
 * This class generates form token and set it to Session.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Token
{
    /**
     * Generates the token to protect form from CSRF attaks and stores into Session.
     */
    public static function generate()
    {
        $token = base64_encode(openssl_random_pseudo_bytes(32));
        return $token;
    }
}