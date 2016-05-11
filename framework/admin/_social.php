<div class="panel hidden" id="social-networks">
    <h3 class="panel-title"><i class="fa fa-share-alt"></i> Social Networks</h3>
    <div class="panel-content">
        <?php
        $admin = new \Framework\Framework\WP\Admin\Admin();
        $adminPanel = new \Framework\Framework\Form\AdminPanelForm('social');
        $adminPanel->addElement(new \Framework\Framework\Form\Type\Text('facebook-link', $admin->getOption('facebook-link'), false, 'Facebook Link', 'Provide the URL of your Facebook account.'));
        $adminPanel->addElement(new \Framework\Framework\Form\Type\Text('youtube-link', $admin->getOption('youtube-link'), false, 'Youtube Link', 'Provide the URL of your Youtube account.'));
        $adminPanel->addElement(new \Framework\Framework\Form\Type\Text('twitter-link', $admin->getOption('twitter-link'), false, 'Twitter Link', 'Provide the URL of your Twitter account.'));
        $adminPanel->addElement(new \Framework\Framework\Form\Type\Text('google-link', $admin->getOption('google-link'), false, 'Google Plus Link', 'Provide the URL of your Facebook account.'));
        $adminPanel->setOutput();
        $adminPanel->render();
        ?>
    </div>
</div>