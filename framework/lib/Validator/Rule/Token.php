<?php

namespace Framework\Framework\Validator\Rule;

use Framework\Framework\Validator\RuleInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * This is the token handler class.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Token implements RuleInterface
{
    public function error()
    {
        return 'Token is invalid or expired.';
    }

    public function check($value, $requiredValue = null)
    {
        return true;
        //return ($r->getSession()->get('token') === $token);
    }
}