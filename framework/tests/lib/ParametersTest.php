<?php

use Framework\Framework\Parameters;

class ParametersTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException Exception
     */
    public function testGetAnInvalidParameter()
    {
        $p = Parameters::get('fake.parameter');
    }

    public function testGetAnValidParameter()
    {
        $p = Parameters::get('app.name');
        $this->assertEquals($p, 'E-Framework');
    }
}