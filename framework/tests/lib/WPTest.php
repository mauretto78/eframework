<?php

use Framework\Framework\Share;
use Framework\Framework\WP\Enqueuer;
use Framework\Framework\WP\PostType\PostType;
use Framework\Framework\WP\PostType\MetaBox;
use Framework\Framework\WP\Path;
use Framework\Framework\WP\Action;
use Framework\Framework\WP\AdminPage;
use Framework\Framework\WP\Ajax;
use Framework\Framework\WP\Nav\Nav;
use Framework\Framework\WP\Post;
use Framework\Framework\WP\Query;
use Framework\Framework\WP\Support;
use Framework\Framework\WP\Breadcrumbs;
use Framework\Framework\WP\Comments\Comments;
use Framework\Framework\WP\Comments\BootstrapComments;
use Framework\Framework\WP\Theme;

class WPTest extends \PHPUnit_Framework_TestCase
{
    protected $enq;
    protected $cpt;
    protected $action;
    protected $ajax;
    protected $nav;
    protected $post;
    protected $support;
    protected $theme;

    public function setUp()
    {
        $this->enq = new Enqueuer();
        $this->cpt = new PostType('Book');
        $this->action = Action::getInstance();
        $this->ajax = new Ajax('general');
        $this->nav = new Nav();
        $this->support = new Support();
        $this->theme = new Theme();
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

    public function testRetrieveSomeInformationAboutCurrentTheme()
    {
        $this->assertEquals(10, count($this->theme->getHeaders()));
        $this->assertTrue(is_string($this->theme->get('name')));
        $this->assertTrue(is_string($this->theme->get('uri')));
        $this->assertTrue(is_string($this->theme->get('description')));
        $this->assertFalse($this->theme->get('a-value-that-not-exists'));
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
        $this->theme->setOption('sample', 1234567890);
        $this->theme->setOption('another_sample', 'this is a simple string');

        $this->assertGreaterThan(0, $this->theme->getCountOptions());
        $this->assertEquals($this->theme->getOption('sample'), 1234567890);
        $this->assertEquals($this->theme->getOption('another_sample'), 'this is a simple string');
    }

    public function testCreateSomeAdminPage()
    {
        $this->theme->addPage(new AdminPage('eframework', 'E-Framework', 'edit_themes', 'layout.php'));
        $this->assertEquals($this->theme->getCountPages(), 1);
    }

    public function testCreateSomeSidebar()
    {
        $this->theme->addSidebar(array(
            'name' => 'Sidebar1',
            'id' => 'sidebar-1',
        ));
        $this->theme->addSidebar(array(
            'name' => 'Sidebar2',
            'id' => 'sidebar-2',
        ));

        $this->assertEquals($this->theme->getSidebar('sidebar-1'), 'sidebar-1');
        $this->assertEquals($this->theme->getSidebar('sidebar-2'), 'sidebar-2');
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

    public function testCreationAndRegistrationAndDestroyOfANavbar()
    {
        $this->theme->registerNavbar('test-nav-area', 'Test Navigation', 'website test navigation menu.');
        $this->nav->create('test-menu');
        $this->nav->addItem(array(
            'menu-item-title' => __('Topics'),
            'menu-item-url' => '#',
            'menu-item-type' => 'custom',
            'menu-item-status' => 'publish', ));
        $this->nav->assignTo('test-nav-area');

        $this->assertTrue($this->theme->hasNavbar('test-nav-area'));

        $this->theme->unregisterNavbar('test-nav-area');
    }

    public function testGetDataFromAPost()
    {
        $p = new Post(1);
        $post = $p->get();
        $date = $p->getDate();

        $this->assertInstanceOf('WP_Post', $post);
        $this->assertInstanceOf('\DateTime', $date);
        $this->assertEquals($p->getTitle(), 'Ciao mondo!');
    }

    public function testInsertNewPostWithSomeDataAndThenUpdateAndFinallyHardDelete()
    {
        // create post
        $p = new Post();
        $data = array(
            'post_title' => 'New Post',
            'post_content' => 'Lorem ipsum dolor facium.',
        );
        $idNew = $p->persist($data);
        $new = new Post($idNew);

        $this->assertEquals($new->getTitle(), 'New Post');
        $this->assertContains('<p>Lorem ipsum dolor facium.</p>', $new->getContent());

        $share = new Share($new->getPermalink(), $new->getTitle(), $new->getExcerpt(), $new->getThumbnailUrl());

        $this->assertEquals($share->render(array('facebook')), '<a class="facebook" href="https://www.facebook.com/sharer/sharer.php?u='.$new->getPermalink().'">Share with Facebook</a>');

        // update post
        $updatedata = array(
            'post_title' => 'Updated Post',
            'post_content' => 'Lorem ipsum dolor facium.',
        );
        $new->persist($updatedata);

        $this->assertEquals($new->getTitle(), 'Updated Post');
        $this->assertContains('<p>Lorem ipsum dolor facium.</p>', $new->getContent());

        // delete post
        $new->destroy(true);
        $this->assertFalse($new->exists());
    }

    public function testSimpleQuery()
    {
        // create a fake page
        $p = new Post();
        $data = array(
            'post_author' => 1,
            'post_type' => 'page',
            'post_title' => 'New Post',
            'post_content' => 'Lorem ipsum dolor facium.',
            'post_status' => 'publish',
            'ping_status' => 'open',
        );
        $idNew = $p->persist($data);
        $new = new Post($idNew);

        $p2 = new Post();
        $data2 = array(
            'post_author' => 1,
            'post_type' => 'page',
            'post_title' => 'New Post 2',
            'post_content' => 'Lorem ipsum dolor facium.',
            'post_status' => 'publish',
            'ping_status' => 'open',
        );
        $idNew2 = $p2->persist($data2);
        $new2 = new Post($idNew2);

        $args = array(
            'post_type' => 'page',
            'posts_per_page' => 2,
            'paged' => 1,
        );
        $q = new Query($args);

        $this->assertEquals(2, $q->getCount());
        $this->assertContains('1', $q->paginate());
        $this->assertContains('2', $q->paginate());

        // delete fake posts
        $new->destroy(true);
        $new2->destroy(true);
        $this->assertFalse($new->exists());
        $this->assertFalse($new2->exists());
    }

    public function testThemeSupport()
    {
        $this->support->add('post-formats', array('aside', 'gallery'));
        $this->support->add('post-thumbnails');

        $this->assertTrue($this->support->check('post-formats'));
        $this->assertTrue($this->support->check('post-thumbnails'));
    }

    public function testBreadcrumbsRender()
    {
        $b = new Breadcrumbs();

        $this->assertEquals('<div class="breadcrumbs"><a href="'.Path::home().'">Home</a></div>', $b->render());

        $b->setWrapperClass('my-custom-breadcrumbs');
        $b->setRootText('My Home');

        $this->assertEquals('<div class="my-custom-breadcrumbs"><a href="'.Path::home().'">My Home</a></div>', $b->render());
    }

    public function testCommentsList()
    {
        $p = new Post(1);
        $c = new Comments($p);

        $this->assertContains('<div class="comment level-0" id="comment-', $c->renderList());

        $bc = new BootstrapComments($p);

        $this->assertContains('<div class="comment level-0" id="comment-', $bc->renderList());
    }
}
