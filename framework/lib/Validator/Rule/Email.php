<?php

namespace Framework\Framework\Validator\Rule;

use Framework\Framework\Validator\RuleInterface;

/**
 * This is the email rule handler class.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Email implements RuleInterface
{
    public function error()
    {
        return '{field} is not a valid email address.';
    }

    public function check($value, $requiredValue = null)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }
}
