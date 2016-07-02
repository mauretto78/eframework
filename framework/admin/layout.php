<?php use Framework\Framework\WP\Path;

?>
<div id="messages"></div>
<div class="framework clearfix">
    <div class="left">
        <div class="logo-wrapper clearfix">
            <img src="<?php echo Path::template('/framework/admin/img/logo.png')?>" alt="" class="logo">
            <span class="toggle-btn">
                <i class="fa fa-bars"></i>
            </span>
        </div>
        <ul class="navigation">
            <li>
                <a class="active" href="#" data-target="#general">
                    <i class="fa fa-home"></i>
                    <span>General</span>
                </a>
            </li>
            <li>
                <a href="#" data-target="#colors">
                    <i class="fa fa-paint-brush"></i>
                    <span>Colors & Fonts</span>
                </a>
            </li>
            <li>
                <a href="#" data-target="#slider">
                    <i class="fa fa-picture-o"></i>
                    <span>Slider Settings</span>
                </a>
            </li>
            <li>
                <a href="#" data-target="#blog">
                    <i class="fa fa-pencil"></i>
                    <span>Blog support</span>
                </a>
            </li>
            <li>
                <a href="#" data-target="#mail">
                    <i class="fa fa-envelope"></i>
                    <span>Mail settings</span>
                </a>
            </li>
            <li>
                <a href="#" data-target="#css">
                    <i class="fa fa-code"></i>
                    <span>Custom CSS</span>
                </a>
            </li>
            <li>
                <a href="#" data-target="#social-networks">
                    <i class="fa fa-share-alt"></i>
                    <span>Social</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="right">
        <?php include '_general.php'; ?>
        <?php include '_colors.php'; ?>
        <?php include '_slider.php'; ?>
        <?php include '_blog.php'; ?>
        <?php include '_mail.settings.php'; ?>
        <?php include '_css.php'; ?>
        <?php include '_social.php'; ?>
    </div>
</div>
<div class="copy">
    copyright <a href="#">E-Framework</a> by Easy Grafica
</div>