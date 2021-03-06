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

    public function testRenderTheShortcodeWithBlankValues()
    {
        $this->s = new Shortcode('img');
        $this->s->setArgument('src');
        $this->s->setArgument('w');
        $this->s->setArgument('h');
        $this->s->setArgument('title');
        $this->s->setOutput('<img src="{src}" width="{w}" height="{h}" alt="{title}" title="{title}">');
        $this->s->create();

        $this->assertEquals(do_shortcode('[img src="http://www.wpclipart.com/American_History/African_A_Rights/Andrew_Young.png"]'), '<img src="http://www.wpclipart.com/American_History/African_A_Rights/Andrew_Young.png" width="" height="" alt="" title="">');
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

    public function testRenderTheShortcodeWithACallbackAndMissingArgumentsOutput()
    {
        $this->s = new Shortcode('claim');
        $this->s->setArgument('title');
        $this->s->setArgument('text');
        $this->s->setArgument('link');
        $this->s->setOutput(array($this, 'claimCallback'));
        $this->s->create();

        $this->assertEquals(do_shortcode('[claim title="title" text="Test Callback"]'), '<section class="claim"><div class="container"><h3>title</h3><span>Test Callback</span></div></section>');
    }

    public function claimCallback($atts)
    {
        $claim = '<section class="claim">';
        $claim .= '<div class="container">';
        if (isset($atts['title'])) {
            $claim .= '<h3>'.$atts['title'].'</h3>';
        }
        if (isset($atts['text'])) {
            $claim .= '<span>'.$atts['text'].'</span>';
        }
        if (isset($atts['link'])) {
            $claim .= '<a href="'.$atts['link'].'" class="btn btn-corporate-o btn-lg rounded">Read more</a>';
        }
        $claim .= '</div>';
        $claim .= '</section>';

        return $claim;
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
