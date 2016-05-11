<div class="panel hidden" id="css">
    <h3 class="panel-title"><i class="fa fa-code"></i> Custom CSS</h3>
    <div class="panel-content">
        <?php
        $admin = new \Framework\Framework\WP\Admin\Admin();
        $adminPanel = new \Framework\Framework\Form\AdminPanelForm('css');
        $adminPanel->addElement(new \Framework\Framework\Form\Type\CSS('custom-css', $admin->getOption('custom-css'), 'Custom CSS', 'Add here your custom CSS code.'));
        $adminPanel->setOutput();
        $adminPanel->render();
        ?>
    </div>
</div>