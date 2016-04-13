<?php

namespace Framework\Framework\Validator\Rule;

use Framework\Framework\Validator\RuleInterface;

/**
 * This is the alphabetic rule handler class.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Alpha implements RuleInterface
{
    public function error()
    {
        return '{field} must be alphabetic.';
    }

    public function check($value, $requiredValue = null)
    {
        return (bool) preg_match('/^[\pL\pM]+$/u', $value);
    }
}
