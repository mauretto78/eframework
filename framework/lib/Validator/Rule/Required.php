<?php

namespace Framework\Framework\Validator\Rule;

use Framework\Framework\Validator\RuleInterface;

/**
 * This is the required rule handler class.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Required implements RuleInterface
{
    public function error()
    {
        return '{field} is required.';
    }

    public function check($value)
    {
        $value = preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u', '', $value);

        return !empty($value);
    }
}
