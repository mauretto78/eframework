<div class="panel hidden" id="colors">
    <h3 class="panel-title"><i class="fa fa-picture-o"></i> Colors</h3>
    <div class="panel-content">
        <?php
        $admin = new \Framework\Framework\WP\Admin\Admin();
        $adminPanel = new \Framework\Framework\Form\AdminPanelForm('colors');
        $adminPanel->addElement(new \Framework\Framework\Form\Type\Color('general_color', $admin->getOption('general_color'), false, 'General Color', 'Choose the base color for the website.'));
        $adminPanel->setOutput();
        $adminPanel->render();

        ?>
    </div>
</div>