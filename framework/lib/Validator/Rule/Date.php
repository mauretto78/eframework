<?php

namespace Framework\Framework\Validator\Rule;

use Framework\Framework\Validator\RuleInterface;

/**
 * This is the date rule handler class.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Date implements RuleInterface
{
    public function error()
    {
        return '{field} must be a valid date.';
    }

    public function check($value, $requiredValue = null)
    {
        if ($value instanceof \DateTime) {
            return true;
        }
        if (strtotime($value) === false) {
            return false;
        }
        $date = date_parse($value);

        return checkdate($date['month'], $date['day'], $date['year']);
    }
}
