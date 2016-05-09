<div class="panel hidden" id="colors">
    <h3 class="panel-title"><i class="fa fa-picture-o"></i> Colors</h3>
    <div class="panel-content">
        <?php
        $baseColor = new \Framework\Framework\Form\Type\Text('general color', '', false, 'General Color', 'Choose the base color for the website.');
        $baseColor->addAttribute('class', 'jscolor');

        $admin = new \Framework\Framework\Form\AdminPanelForm();
        $admin->addElement($baseColor);
        $admin->setOutput();
        $admin->render();
        ?>
    </div>
</div>