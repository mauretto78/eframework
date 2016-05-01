<?php

use Framework\Framework\WP\Enqueuer;
use Framework\Framework\WP\PostType\PostType;
use Framework\Framework\WP\PostType\MetaBox;
use Framework\Framework\WP\Path;
use Framework\Framework\WP\Admin\Admin;
use Framework\Framework\WP\Admin\AdminPage;

require_once __DIR__.'/../../../../../../wp-load.php'; // Worpdress

class WPTest extends \PHPUnit_Framework_TestCase
{
    protected $enq;
    protected $cpt;
    protected $nav;

    public function setUp()
    {
        $this->enq = new Enqueuer();
        $this->cpt = new PostType('Book');
        $this->admin = new Admin();
    }

    public function testEnqueueSomeFiles()
    {
        $this->enq->addAdminScript('admin-script', Path::template('/js/admin.js'), array(), '1.0.0', true);
        $this->enq->addFrontendScript('front-end-script', Path::template('/js/bootstrap.js'), array(), '1.0.0', true);
        $this->enq->addAdminStyle('admin-style', Path::template('/css/admin.css'), array(), '1.0.0', true);
        $this->enq->addFrontendStyle('front-end-style', Path::template('/css/app.css'), array(), '1.0.0', true);

        $this->assertEquals(2, count($this->enq->getAdminFiles()));
        $this->assertEquals(2, count($this->enq->getFrontendFiles()));
        $this->assertTrue($this->enq->enqueue());
    }

    public function testCreateSomeNewCustomPostType()
    {
        $this->cpt->setAttribute('label', 'this is the label');
        $this->cpt->setAttribute('public', false);
        $this->cpt->addTaxonomy('typology');
        $this->cpt->addMetaBox(
            new MetaBox('Book Info', array(
                'isbn' => 'text',
                'rating' => 'text',
                'review' => 'textarea', )));
        $this->assertTrue($this->cpt->register());
    }

    public function testCreateAndRetrieveOptions()
    {
        $this->admin->setOption('sample', 1234567890);
        $this->admin->setOption('another_sample', 'this is a simple string');

        $this->assertGreaterThan(0, $this->admin->getCountOptions());
        $this->assertEquals($this->admin->getOption('sample'), 1234567890);
        $this->assertEquals($this->admin->getOption('another_sample'), 'this is a simple string');
    }

    public function testCreateSomeAdminPage()
    {
        $this->admin->addPage(new AdminPage('eframework', 'E-Framework', 'edit_themes', 'layout.php'));
        $this->assertEquals($this->admin->getCountPages(), 1);
    }
}
