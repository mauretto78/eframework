<?php

use Framework\Framework\WP\Shortcode;

class ShortcodeTest extends PHPUnit_Framework_TestCase
{
    public function testGetArgumentCount()
    {
        $this->s = new Shortcode('testCount');
        $this->s->setArgument('title');
        $this->s->setArgument('description');
        $this->s->setArgument('link');
        $this->assertEquals($this->s->getCountArguments(), 3);
    }

    public function testRenderTheShortcodeWithASimpleOutput()
    {
        $this->s = new Shortcode('test');
        $this->s->setArgument('title');
        $this->s->setArgument('description');
        $this->s->setArgument('link');
        $this->s->setOutput('<div><span class="t">{title}</span><span class="d">{description}</span><a href="{link}" class="link">Read more</a></div>');
        $this->s->create();

        $this->assertEquals(do_shortcode('[test title="titolo" description="lorem ipsum" link="#"]'), '<div><span class="t">titolo</span><span class="d">lorem ipsum</span><a href="#" class="link">Read more</a></div>');
    }

    public function testRenderTheShortcodeWithACallbackOutput()
    {
        $this->callback = new Shortcode('callback');
        $this->callback->setArgument('argument');
        $this->callback->setOutput(array($this, 'simpleCallback'));
        $this->callback->create();

        $this->assertEquals(do_shortcode('[callback id="test_callback" content="Test Callback"]'), "<div id='test_callback'>Test Callback</div>");
    }

    public function simpleCallback($atts)
    {
        return "<div id='".$atts['id']."'>".$atts['content'].'</div>';
    }

    public function testRenderTheShortcodeWithADynamicContentOutput()
    {
        $this->container = new Shortcode('container');
        $this->container->setOutput('<div class="container">{{content}}</div>');
        $this->container->create();

        $this->row = new Shortcode('row');
        $this->row->setOutput('<div class="row">{{content}}</div>');
        $this->row->create();

        $this->col = new Shortcode('col');
        $this->col->setArgument('number');
        $this->col->setOutput('<div class="col-sm-{number}">{{content}}</div>');
        $this->col->create();

        $this->assertEquals(do_shortcode('[container][row][col number="3"]il tuo contenuto qui[/col][/row][/container]'), '<div class="container"><div class="row"><div class="col-sm-3">il tuo contenuto qui</div></div></div>');
    }
}
