<?php

namespace Framework\Framework\Validator\Rule;

use Framework\Framework\Validator\RuleInterface;

/**
 * This is the boolean rule handler class.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Boolean implements RuleInterface
{
    public function error()
    {
        return '{field} must be a boolean.';
    }

    public function check($value, $requiredValue = null)
    {
        return is_bool($value);
    }
}
