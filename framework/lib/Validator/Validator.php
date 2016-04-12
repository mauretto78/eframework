<?php

namespace Framework\Framework\Validator;
use Framework\Framework\Validator\Rule;

/**
 * This class handles data validation.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Validator
{
    /**
     * @var ErrorHandler
     */
    private $errorHandler;

    /**
     * @var array
     */
    private $data = array();

    /**
     * @var array
     */
    private $rules = array();

    /**
     * Validator constructor.
     *
     * @param ErrorHandler $errorHandler
     */
    public function __construct(ErrorHandler $errorHandler)
    {
        $this->errorHandler = $errorHandler;
    }

    /**
     * Validates the data matching against the provided rules.
     *
     * @param array $data
     * @param array $rules
     */
    public function validate($data = array(), $rules = array())
    {
        $this->data = $data;
        $this->rules = $rules;

        foreach ($data as $field => $value) {
            if (in_array($field, array_keys($rules))) {
                $this->_validateField($rules[$field], $field, $value);
            }
        }

        return $this;
    }

    /**
     * Returns true if the validation has no errors.
     *
     * @return bool
     */
    public function errors()
    {
        return $this->errorHandler->getAllErrors();
    }

    /**
     * Returns true if the validation has no errors.
     *
     * @return bool
     */
    public function passes()
    {
        return (count($this->errorHandler->getAllErrors())) ? false : true;
    }

    /**
     * Returns true if the validation fails.
     *
     * @return bool
     */
    public function fails()
    {
        return (count($this->errorHandler->getAllErrors())) ? true : false;
    }

    /**
     * Parses the provided rules and calls the corresponding Rule class check method.
     *
     * @param $rules
     *
     * @return bool
     */
    private function _validateField($rule, $field, $value)
    {
        $rules = explode("|",$rule);

        foreach($rules as $rule){

            if(strpos($rule,":")){
                $rule = explode(":",$rule);
                $rule = $rule[0];
            }

            $className = "Framework\\Framework\\Validator\\Rule\\".ucwords($rule);
            $passed = call_user_func_array( array( new $className(), 'check' ), array($value) );

            if(!$passed){
                $this->errorHandler->addError($rule, $field, $value);

                return false;
            }
        }

        return true;
    }
}
