<div class="panel hidden" id="social-networks">
    <h3 class="panel-title"><i class="fa fa-share-alt"></i> Social Networks</h3>
    <div class="panel-content">
        <?php
        use Framework\Framework\WP\Admin\Admin;
use Framework\Framework\Form\AdminPanelForm;
use Framework\Framework\Form\Type\Text;

$admin = new Admin();
        $adminPanel = new AdminPanelForm('social');
        $adminPanel->addElement(new Text('facebook-link', $admin->getOption('facebook-link'), false, 'Facebook Link', 'Provide the URL of your Facebook account.'));
        $adminPanel->addElement(new Text('youtube-link', $admin->getOption('youtube-link'), false, 'Youtube Link', 'Provide the URL of your Youtube account.'));
        $adminPanel->addElement(new Text('twitter-link', $admin->getOption('twitter-link'), false, 'Twitter Link', 'Provide the URL of your Twitter account.'));
        $adminPanel->addElement(new Text('google-link', $admin->getOption('google-link'), false, 'Google Plus Link', 'Provide the URL of your Google Plus account.'));
        $adminPanel->addElement(new Text('pinterest-link', $admin->getOption('pinterest-link'), false, 'Pinterest Link', 'Provide the URL of your Pinterest account.'));
        $adminPanel->addElement(new Text('instagram-link', $admin->getOption('instagram-link'), false, 'Instagram Link', 'Provide the URL of your Instagram account.'));
        $adminPanel->setOutput();
        $adminPanel->render();
        ?>
    </div>
</div>