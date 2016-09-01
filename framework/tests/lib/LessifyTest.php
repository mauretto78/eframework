<?php

use Framework\Framework\Lessify;

class LessifyTest extends PHPUnit_Framework_TestCase
{
    protected $less;

    public function setUp()
    {
        $this->less = new Lessify(new Less_Parser());
    }

    public function testParseASingleLessFile()
    {
        $origin = __DIR__.'/fixtures/lessify/single.less';
        $target = __DIR__.'/fixtures/lessify/single.css';

        $this->less->parseIntoFile($origin, $target);

        $this->assertEquals(file_get_contents($target), 'body{background: #666;color: #999;border: 1px solid #ddd}');
    }

    public function testParseTwoLessFiles()
    {
        $origin = array(__DIR__.'/fixtures/lessify/array1.less', __DIR__.'/fixtures/lessify/array2.less');
        $target = __DIR__.'/fixtures/lessify/array.css';

        file_put_contents($target, '');         // 1. empty the file first
        $this->less->parseIntoFile($origin, $target);   // 2. parse two files into target

        $this->assertEquals(file_get_contents($target), 'body{background: #ddd}body a{color: #999}body a:hover{color: #666}.container{background: #ddd}.container p{color: #999}.container p.first{color: #666}');
    }
}
