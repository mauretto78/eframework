<?php

namespace Framework\Framework\Form;

use Framework\Framework\Session\SessionBridge;

/**
 * This class generates form token and check it.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Token extends SessionBridge
{
    /**
     * Check if token matches.
     */
    public function check($token)
    {
        return ($token === $this->session->get('token')) ? true : false;
    }

    /**
     * Generates the token to protect form from CSRF attaks and stores into Session.
     */
    public function generate()
    {
        $token = base64_encode(openssl_random_pseudo_bytes(32));
        $this->session->set('token', $token);

        return $token;
    }
}
