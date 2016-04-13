<?php

namespace Framework\Framework\Validator;

/**
 * This is the general interface for the rules classes.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
interface RuleInterface
{
    /**
     * The error given if the rule fails.
     *
     * @return string
     */
    public function error();

    /**
     * Performs the check on the provided value.
     *
     * @return bool
     */
    public function check($value, $requiredValue);
}
