<?php

namespace Framework\Framework\Validator\Rule;

use Framework\Framework\Validator\RuleInterface;

/**
 * This is the number rule handler class.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Number implements RuleInterface
{
    public function error()
    {
        return '{field} must be a number.';
    }

    public function check($value, $requiredValue = null)
    {
        return is_numeric($value);
    }
}
