<?php

use Framework\Framework\WP\Shortcode;

// [container]
$s = new Shortcode('container');
$s->setOutput('<div class="container">{{content}}</div>');
$s->create();

// [row]
$s = new Shortcode('row');
$s->setOutput('<div class="row">{{content}}</div>');
$s->create();

// [col]
$s = new Shortcode('col');
$s->setArgument('number');
$s->setOutput('<div class="col-sm-{number}">{{content}}</div>');
$s->create();

// [link]
$s = new Shortcode('link');
$s->setArgument('href');
$s->setArgument('target');
$s->setArgument('text');
$s->setOutput('<a href="{href}" target="{target}">{text}</a>');
$s->create();

/* [img] */
$s = new Shortcode('img');
$s->setArgument('src');
$s->setArgument('w');
$s->setArgument('h');
$s->setArgument('title');
$s->setOutput('<img src="{src}" width="{w}" height="{h}" alt="{title}" title="{title}">');
$s->create();

// [iframe]
$s = new Shortcode('iframe');
$s->setArgument('src');
$s->setArgument('w');
$s->setArgument('h');
$s->setOutput('<iframe src="{src}" width="{w}" height="{h}"></iframe>');
$s->create();

// [youtube]
$s = new Shortcode('youtube');
$s->setArgument('id');
$s->setArgument('w');
$s->setArgument('h');
$s->setOutput('<iframe class="youtube" src="https://www.youtube.com/embed/{id}" style="width:{w}; height:{h};" frameborder="0" allowfullscreen></iframe>');
$s->create();