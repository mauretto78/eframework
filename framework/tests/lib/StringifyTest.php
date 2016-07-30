<?php

use Framework\Framework\Stringify;

class StringifyTest extends PHPUnit_Framework_TestCase
{
    public function testFromNormalStringToCamelConversion()
    {
        $string = 'String to convert to camel case';
        $ccstring = Stringify::toCamel($string);

        $this->assertEquals('StringToConvertToCamelCase', $ccstring);
    }

    public function testFromAccentedStringToCamelConversion()
    {
        $string = 'Arrivò e mi disse viva gli accenti';
        $ccstring = Stringify::toCamel($string);

        $this->assertEquals('ArrivoEMiDisseVivaGliAccenti', $ccstring);
    }

    public function testFromCamelToSnakeConversion()
    {
        $string = 'StringToConvertToSnakeCase';
        $scstring = Stringify::toSnake($string);

        $this->assertEquals('string_to_convert_to_snake_case', $scstring);
    }

    public function testFromNormalStringToSnakeConversion()
    {
        $string = 'String to convert to snake case';
        $scstring = Stringify::toSnake($string);

        $this->assertEquals('string_to_convert_to_snake_case', $scstring);
    }

    public function testFromAccentedStringToSnakeConversion()
    {
        $string = 'Arrivò e mi disse viva gli accenti';
        $scstring = Stringify::toSnake($string);

        $this->assertEquals('arrivo_mi_disse_viva_gli_accenti', $scstring);
    }

    public function testFromSnakeToNormalStringConversion()
    {
        $string = 'string_to_convert_to_snake_case';
        $scstring = Stringify::fromSnake($string);

        $this->assertEquals('String to convert to snake case', $scstring);
    }

    public function testSeoStringConversion()
    {
        $string = 'Questo è il titolo di una stringa per il SEO, ovvero uno slug.';
        $seostring = Stringify::slug($string);

        $this->assertEquals('questo-e-il-titolo-di-una-stringa-per-il-seo-ovvero-uno-slug', $seostring);
    }
}
