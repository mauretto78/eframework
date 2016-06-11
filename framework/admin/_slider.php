<div class="panel hidden" id="slider">
    <h3 class="panel-title"><i class="fa fa-picture-o"></i> Slider Settings</h3>
    <div class="panel-content">
        <?php
        $admin = new \Framework\Framework\WP\Admin\Admin();
        $adminPanel = new \Framework\Framework\Form\AdminPanelForm('slider');
        $adminPanel->addElement(new \Framework\Framework\Form\Type\Slider('homepage_slider', 'Homepage Slider', 'Setup your homepage slider. You can sort it by drag and drop. Please notice only slides with image will be displayed.'));
        $adminPanel->setOutput();
        $adminPanel->render();
        ?>
    </div>
</div>