<?php

use Framework\Framework\Sluggify;

class SluggifyTest extends PHPUnit_Framework_TestCase
{
    public function testParsingAString()
    {
        $string = 'La Marianna va in campagna quando il sole tramonterà!...chissà quando ritornerà!';
        $parsed = Sluggify::generate($string);

        $this->assertEquals($parsed, 'la-marianna-va-in-campagna-quando-il-sole-tramontera-chissa-quando-ritornera');
    }
}
