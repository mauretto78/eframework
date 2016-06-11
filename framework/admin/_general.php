<div class="panel" id="general">
    <h3 class="panel-title"><i class="fa fa-home"></i> General Settings</h3>
    <div class="panel-content">
        <?php
        $admin = new \Framework\Framework\WP\Admin\Admin();
        $adminPanel = new \Framework\Framework\Form\AdminPanelForm('general');
        $adminPanel->addElement(new \Framework\Framework\Form\Type\Media('company-logo', $admin->getOption('company-logo'), 'Your Logo', 'Upload your Company Logo.'));
        $adminPanel->addElement(new \Framework\Framework\Form\Type\Media('company-favicon', $admin->getOption('company-favicon'), 'Your Favicon', 'Upload your Company Favicon.'));
        $adminPanel->addElement(new \Framework\Framework\Form\Type\Text('company-name', $admin->getOption('company-name'), false, 'Company Name', 'Provide your Company name.'));
        $adminPanel->addElement(new \Framework\Framework\Form\Type\Text('company-email', $admin->getOption('company-email'), false, 'Company Email', 'Provide your Company email.'));
        $adminPanel->addElement(new \Framework\Framework\Form\Type\Text('company-telephone', $admin->getOption('company-telephone'), false, 'Company Telephone', 'Provide your Company phone number.'));
        $adminPanel->addElement(new \Framework\Framework\Form\Type\Text('company-mobile', $admin->getOption('company-mobile'), false, 'Company Mobile', 'Provide your Company mobile number.'));
        $adminPanel->addElement(new \Framework\Framework\Form\Type\Text('company-fax', $admin->getOption('company-fax'), false, 'Company Fax', 'Provide your Company fax.'));
        $adminPanel->addElement(new \Framework\Framework\Form\Type\Text('company-address', $admin->getOption('company-address'), false, 'Company Address', 'Provide your Company address.'));
        $adminPanel->setOutput();
        $adminPanel->render();
        ?>
    </div>
</div>