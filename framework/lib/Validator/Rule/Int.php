<?php

namespace Framework\Framework\Validator\Rule;

use Framework\Framework\Validator\RuleInterface;

/**
 * This is the integer rule handler class.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Int implements RuleInterface
{
    public function error()
    {
        return '{field} must be an integer.';
    }

    public function check($value)
    {
        return is_numeric($value) && (int)$value == $value;
    }
}