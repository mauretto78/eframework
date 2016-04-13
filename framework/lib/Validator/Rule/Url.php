<?php

namespace Framework\Framework\Validator\Rule;

use Framework\Framework\Validator\RuleInterface;

/**
 * This is the url rule handler class.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Url implements RuleInterface
{
    public function error()
    {
        return '{field} must be a valid URL.';
    }

    public function check($value, $requiredValue = null)
    {
        return filter_var($value, FILTER_VALIDATE_URL) !== false;
    }
}
