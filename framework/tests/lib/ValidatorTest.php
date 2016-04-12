<?php

use Framework\Framework\Validator\Validator;

class ValidatorTest extends PHPUnit_Framework_TestCase
{
    protected $v;

    public function setUp()
    {
        $this->v = new Validator(new \Framework\Framework\Validator\ErrorHandler());
    }

    public function testInvalidData()
    {
        $input = [
            'first_name'    => 'Mauro',
            'last_name'     => '',
            'age'           => 37,
            'email'         => 'assistenza@easy-grafica.com'
        ];
        $rules = [
            'first_name'    => 'required|alpha|min:3|max:40',
            'last_name'     => 'required|alpha|min:5',
            'age'           => 'required|number|int',
            'email'         => 'required|email',
        ];

        $this->v->validate($input, $rules);

        $this->assertTrue($this->v->fails());
        $this->assertFalse($this->v->passes());
    }

    public function testValidData()
    {

    }
}