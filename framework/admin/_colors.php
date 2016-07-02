<div class="panel hidden" id="colors">
    <h3 class="panel-title"><i class="fa fa-picture-o"></i> Colors</h3>
    <div class="panel-content">
        <?php
        use Framework\Framework\WP\Admin\Admin;
        use Framework\Framework\Form\AdminPanelForm;
        use Framework\Framework\Form\Type\Color;
        use Framework\Framework\Form\Type\Choice;
        use Framework\Framework\GoogleFont;

        $googleFonts = new GoogleFont();
        $admin = new Admin();
        $adminPanel = new AdminPanelForm('colors');
        $adminPanel->addElement(new Color('general_color', $admin->getOption('general_color'), false, 'General Color', 'Choose the base color for the website.'));
        $adminPanel->addElement(new Color('background_color', $admin->getOption('background_color'), false, 'Background Color', 'Choose the background color for the website.'));
        $adminPanel->addElement(new Choice('general-font', $googleFonts->getFontList(), $admin->getOption('general-font'), false, 'General Font', 'Choose the general font for your website.'));
        $adminPanel->addElement(new Choice('titles-font', $googleFonts->getFontList(), $admin->getOption('titles-font'), false, 'Titles Font', 'Choose the general font for your website.'));
        $adminPanel->setOutput();
        $adminPanel->render();

        ?>
    </div>
</div>