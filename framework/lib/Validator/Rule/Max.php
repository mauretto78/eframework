<?php

namespace Framework\Framework\Validator\Rule;

use Framework\Framework\Validator\RuleInterface;

/**
 * This is the max rule handler class.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Max implements RuleInterface
{
    public function error()
    {
        return '{field} must be a maximum of {requiredValue}.';
    }

    public function check($value, $requiredValue)
    {
        return mb_strlen($value) <= (int) $requiredValue;
    }
}
