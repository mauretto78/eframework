<?php

namespace Framework\Framework\Validator;

/**
 * This class handles errors of data validation.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class ErrorHandler
{
    /**
     * @var array
     */
    private $errors = array();

    public function addError($rule, $field, $value)
    {
        $className = 'Framework\\Framework\\Validator\\Rule\\'.ucwords($rule);
        $msg = call_user_func_array(array(new $className(), 'error'), array($value));
        $this->errors[$field] = str_replace('{field}', $field, $msg);
    }

    public function getAllErrors()
    {
        return $this->errors;
    }
}
