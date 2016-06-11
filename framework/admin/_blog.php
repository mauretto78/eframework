<div class="panel hidden" id="blog">
    <h3 class="panel-title"><i class="fa fa-newspaper-o"></i> Blog layout</h3>
    <div class="panel-content">
        <?php
        $admin = new \Framework\Framework\WP\Admin\Admin();
        $adminPanel = new \Framework\Framework\Form\AdminPanelForm('blog');
        $formats = array(
            'Aside Post' => 'aside',
            'Gallery Post' => 'gallery',
            'Link Post' => 'link',
            'Image Post' => 'image',
            'Quote Post' => 'quote',
            'Status Post' => 'status',
            'Video Post' => 'video',
            'Audio Post' => 'audio',
            'Chat Post' => 'chat',
        );
        $adminPanel->addElement(new \Framework\Framework\Form\Type\Checkbox('blog_support_formats', $formats, \Framework\Framework\Serializer::unserialize($admin->getOption('blog_support_formats')), false, 'Blog Support', 'Choose what type of post the blog supports.'));
        $adminPanel->setOutput();
        $adminPanel->render();
        ?>
    </div>
</div>



