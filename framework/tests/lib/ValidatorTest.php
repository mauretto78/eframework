<?php

use Framework\Framework\Validator\Validator;
use Framework\Framework\Validator\ErrorHandler;
use Symfony\Component\HttpFoundation\Request;

class ValidatorTest extends PHPUnit_Framework_TestCase
{
    protected $v;

    public function setUp()
    {
        $this->v = new Validator(new ErrorHandler(), new Request());
    }

    public function testInvalidRuleException()
    {
        $test = function () {
            $input = [
                'first_name' => 'Mauro',
            ];
            $rules = [
                'first_name' => 'required|alphaaaa',
            ];

            $this->v->validate($input, $rules);
        };
        $this->assertException($test, 'InvalidArgumentException', 0, 'Class rule doesn\'t exist');
    }

    public function testInvalidData()
    {
        $input = [
            'first_name' => 'Mauro',
            'last_name' => '',
            'age' => 37,
            'ip' => 'xxxxxxx.xxx.xx',
            'email' => 'assistenza@easy-grafica.com',
        ];
        $rules = [
            'first_name' => 'required|alpha|min:3|max:40',
            'last_name' => 'required|alpha|min:5',
            'ip' => 'required|ip',
            'age' => 'required|number|int',
            'email' => 'required|email',
        ];

        $this->v->validate($input, $rules);

        $this->assertTrue($this->v->fails());
        $this->assertFalse($this->v->passes());
        $this->assertEquals(count($this->v->errors()), 2);
        $this->assertEquals($this->v->errors()['last_name'], 'last_name is required.');
        $this->assertEquals($this->v->errors()['ip'], 'ip is not a valid IP address.');
    }

    public function testValidDataWithAllRules()
    {
        $input = [
            'first_name' => 'Mauro',
            'last_name' => 'Cassani',
            'age' => 37,
            'ip' => '192.0.0.1',
            'isPremium' => true,
            'BirthDate' => '01/08/1978',
            'email' => 'assistenza@easy-grafica.com',
            'web' => 'http://www.easy-grafica.com',
        ];
        $rules = [
            'first_name' => 'required|alpha|min:3|max:40',
            'last_name' => 'required|alpha|min:5',
            'ip' => 'required|ip',
            'age' => 'required|number|int',
            'isPremium' => 'required|boolean',
            'BirthDate' => 'required|date',
            'email' => 'required|email',
            'web' => 'required|url',
        ];

        $this->v->validate($input, $rules);

        $this->assertFalse($this->v->fails());
        $this->assertTrue($this->v->passes());
    }

    protected function assertException(callable $callback, $expectedException = 'Exception', $expectedCode = null, $expectedMessage = null)
    {
        $expectedException = ltrim((string) $expectedException, '\\');
        if (!class_exists($expectedException) && !interface_exists($expectedException)) {
            $this->fail(sprintf('An exception of type "%s" does not exist.', $expectedException));
        }
        try {
            $callback();
        } catch (\Exception $e) {
            $class = get_class($e);
            $message = $e->getMessage();
            $code = $e->getCode();
            $errorMessage = 'Failed asserting the class of exception';
            if ($message && $code) {
                $errorMessage .= sprintf(' (message was %s, code was %d)', $message, $code);
            } elseif ($code) {
                $errorMessage .= sprintf(' (code was %d)', $code);
            }
            $errorMessage .= '.';
            $this->assertInstanceOf($expectedException, $e, $errorMessage);
            if ($expectedCode !== null) {
                $this->assertEquals($expectedCode, $code, sprintf('Failed asserting code of thrown %s.', $class));
            }
            if ($expectedMessage !== null) {
                $this->assertContains($expectedMessage, $message, sprintf('Failed asserting the message of thrown %s.', $class));
            }

            return;
        }
        $errorMessage = 'Failed asserting that exception';
        if (strtolower($expectedException) !== 'exception') {
            $errorMessage .= sprintf(' of type %s', $expectedException);
        }
        $errorMessage .= ' was thrown.';
        $this->fail($errorMessage);
    }
}
