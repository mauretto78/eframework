<?php

namespace Framework\Framework\Validator\Rule;

use Framework\Framework\Validator\RuleInterface;

/**
 * This is the min rule handler class.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Min implements RuleInterface
{
    public function error()
    {
        return '{field} must be a minimum of {requiredValue}.';
    }

    public function check($value, $requiredValue)
    {
        return mb_strlen($value) >= (int) $requiredValue;
    }
}
