<?php

use Framework\Framework\WP\Enqueuer;
use Framework\Framework\WP\PostType\PostType;
use Framework\Framework\WP\PostType\MetaBox;
use Framework\Framework\WP\Path;
use Framework\Framework\WP\Action;
use Framework\Framework\WP\Admin\Admin;
use Framework\Framework\WP\Admin\AdminPage;
use Framework\Framework\WP\Ajax;
use Framework\Framework\WP\Nav\Nav;
use Framework\Framework\WP\Post;

require_once __DIR__.'/../../../../../../wp-load.php'; // Load Worpdress

class WPTest extends \PHPUnit_Framework_TestCase
{
    protected $enq;
    protected $cpt;
    protected $admin;
    protected $action;
    protected $ajax;
    protected $nav;
    protected $post;

    public function setUp()
    {
        $this->enq = new Enqueuer();
        $this->cpt = new PostType('Book');
        $this->admin = new Admin();
        $this->action = Action::getInstance();
        $this->ajax = new Ajax('general');
        $this->nav = new Nav();
        $this->post = new Post(1);
    }

    public function tearDown()
    {
        Action::tearDown();
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
        $this->cpt->setColumns(array(
            'ISBN code' => 'isbn',
            'Rating' => 'rating',
        ));

        $this->assertEquals(3, $this->cpt->getColumnsCount());
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

    public function testCreateSomeSidebar()
    {
        $this->admin->addSidebar('Sidebar1', 'sidebar-1');
        $this->admin->addSidebar('Sidebar2', 'sidebar-2');

        $this->assertEquals($this->admin->getSidebar('sidebar-1'), 'sidebar-1');
        $this->assertEquals($this->admin->getCountSidebars(), 2);
    }

    public function testCreateSomeActions()
    {
        $this->action->add('test', array($this, 'testActionCallback'));
        $this->action->filter('test', array($this, 'testFilterCallback'));
        $this->assertEquals($this->action->getAction('test'), 'this is a simple action callback function');
        $this->assertEquals($this->action->getFilter('test'), 'this is a simple filter callback function');
    }

    public function testActionCallback()
    {
        return 'this is a simple action callback function';
    }

    public function testFilterCallback()
    {
        return 'this is a simple filter callback function';
    }

    public function testFailureAjaxProcessData()
    {
        $nonce = wp_create_nonce('non_valid_nonce_action');
        $_POST['data'] = 'company-name=EFramework&company-email=assistenza@easy-grafica.com&company-telephone=800800800&company-mobile=32900000000&company-fax=400400400&company-address=Dawning Street, 12&action=general&general_nonce_field='.$nonce;
        $this->assertEquals($this->ajax->handle(), 'Nonce is invalid');
    }

    public function testSuccessfulAjaxProcessData()
    {
        $nonce = wp_create_nonce('general_nonce_action');
        $_POST['data'] = 'company-name=EFramework&company-email=assistenza@easy-grafica.com&company-telephone=800800800&company-mobile=32900000000&company-fax=400400400&company-address=Dawning Street, 12&action=general&general_nonce_field='.$nonce;
        $handle = $this->ajax->handle();

        $this->assertEquals(count($this->ajax->getData()), 6);
        $this->assertEquals($this->ajax->getData()['company-name'], 'EFramework');
        $this->assertTrue($handle);
    }

    public function testCreationOfANavbar()
    {
        $this->nav->create('primary', 'Primary Navigation', 'website primary navigation menu.');

        $this->assertTrue($this->nav->exists('primary'));
    }

    public function testGetDataFromAPost()
    {
        $post = $this->post->get();
        $date = $this->post->getDate();

        $this->assertInstanceOf('WP_Post', $post);
        $this->assertInstanceOf('\DateTime', $date);
        $this->assertEquals($this->post->getTitle(), 'Ciao mondo!');
        $this->assertEquals($this->post->getCategoryCount(), 1);
        $this->assertEquals($this->post->getTagsCount(), 1);
    }

    public function testInsertNewPostWithSomeData()
    {
        $p = new Post();
        $data = array(
            'post_title' => 'New Post',
            'post_content' => 'Lorem ipsum dolor facium.',
        );
        $idNew = $p->persist($data);
        $new = new Post($idNew);

        $this->assertEquals($new->getTitle(), 'New Post');
        $this->assertContains('<p>Lorem ipsum dolor facium.</p>', $new->getContent());
    }

    public function testUpdatePostWithSomeData()
    {
        $p = new Post(10);
        $data = array(
            'post_title' => 'Updated Post',
            'post_content' => 'Lorem ipsum dolor facium.',
        );
        $p->persist($data);

        $this->assertEquals($p->getTitle(), 'Updated Post');
        $this->assertContains('<p>Lorem ipsum dolor facium.</p>', $p->getContent());
    }
}
