<div class="panel hidden" id="css">
    <h3 class="panel-title"><i class="fa fa-code"></i> Custom CSS</h3>
    <div class="panel-content">
        <?php
        $admin = new \Framework\Framework\Form\AdminPanelForm();
        $admin->addElement(new \Framework\Framework\Form\Type\CSS('custom-css', '', 'Custom CSS', 'Add here your custom CSS code.'));
        $admin->setOutput();
        $admin->render();
        ?>
    </div>
</div>