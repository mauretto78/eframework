<div class="panel hidden" id="social-networks">
    <h3 class="panel-title"><i class="fa fa-share-alt"></i> Social Networks</h3>
    <div class="panel-content">
        <?php
        $admin = new \Framework\Framework\Form\AdminPanelForm();
        $admin->addElement(new \Framework\Framework\Form\Type\Text('facebook-link', '', false, 'Facebook Link', 'Provide the URL of your Facebook account.'));
        $admin->addElement(new \Framework\Framework\Form\Type\Text('youtube-link', '', false, 'Youtube Link', 'Provide the URL of your Youtube account.'));
        $admin->addElement(new \Framework\Framework\Form\Type\Text('twitter-link', '', false, 'Twitter Link', 'Provide the URL of your Twitter account.'));
        $admin->addElement(new \Framework\Framework\Form\Type\Text('google-link', '', false, 'Google Plus Link', 'Provide the URL of your Facebook account.'));
        $admin->setOutput();
        $admin->render();
        ?>
    </div>
</div>