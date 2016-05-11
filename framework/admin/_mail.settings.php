<div class="panel hidden" id="mail">
    <h3 class="panel-title"><i class="fa fa-envelope"></i> Mail Settings</h3>
    <div class="panel-content">
        <?php
        $admin = new \Framework\Framework\WP\Admin\Admin();
        $adminPanel = new \Framework\Framework\Form\AdminPanelForm('mail.settings');
        $adminPanel->addElement(new \Framework\Framework\Form\Type\Text('mailer.port', $admin->getOption('mailer.port'), false, 'Mailer port', 'Provide your mailer port (ex. 465).'));
        $adminPanel->addElement(new \Framework\Framework\Form\Type\Text('mailer.smtp', $admin->getOption('mailer.smtp'), false, 'Mailer SMTP address', 'Provide your mailer SMTP address (ex. smtp.gmail.com).'));
        $adminPanel->addElement(new \Framework\Framework\Form\Type\Text('mailer.username', $admin->getOption('mailer.username'), false, 'Mailer username', 'Provide your mailer username.'));
        $adminPanel->addElement(new \Framework\Framework\Form\Type\Text('mailer.password', $admin->getOption('mailer.password'), false, 'Mailer password', 'Provide your mailer password.'));
        $adminPanel->setOutput();
        $adminPanel->render();
        ?>
    </div>
</div>