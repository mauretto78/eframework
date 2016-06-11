<?php

use Framework\Framework\GoogleFont;

class GFTest extends PHPUnit_Framework_TestCase
{
    protected $gf;

    public function setUp()
    {
        $this->gf = new GoogleFont();
    }

    public function testGetListOfGoogleFonts()
    {
        $fontFile = $this->gf->getFontFile();
        $fontList = $this->gf->getFonts('all');

        $this->assertContains('/../cache/google-web-fonts.txt', $fontFile);
        $this->assertGreaterThan(500, count($fontList));
    }
}
