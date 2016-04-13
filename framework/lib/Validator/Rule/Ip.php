<?php

namespace Framework\Framework\Validator\Rule;

use Framework\Framework\Validator\RuleInterface;

/**
 * This is the IP rule handler class.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Ip implements RuleInterface
{
    public function error()
    {
        return '{field} is not a valid IP address.';
    }

    public function check($value, $requiredValue = null)
    {
        return filter_var($value, FILTER_VALIDATE_IP) !== false;
    }
}
