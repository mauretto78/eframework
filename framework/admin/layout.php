<?php
use Framework\Framework\Form\AdminPanelForm;
use Framework\Framework\WP\Path;
?>

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
                <a class="active" href="#" data-target="#panel-1">
                    <i class="fa fa-home"></i>
                    <span>General</span>
                </a>
            </li>
            <li>
                <a href="#" data-target="#panel-2">
                    <i class="fa fa-home"></i>
                    <span>Generale</span>
                </a>
            </li>
            <li>
                <a href="#" data-target="#panel-3">
                    <i class="fa fa-home"></i>
                    <span>Generale</span>
                </a>
            </li>
            <li>
                <a href="#" data-target="#panel-4">
                    <i class="fa fa-home"></i>
                    <span>Generale</span>
                </a>
            </li>
            <li>
                <a href="#" data-target="#panel-5">
                    <i class="fa fa-share-alt"></i>
                    <span>Social</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="right">
        <div class="panel" id="panel-1">
            <h3 class="panel-title">Panel Title</h3>
            <div class="panel-content">
                <?php
                $adminForm = new AdminPanelForm('','POST','','admin-form');
                $adminForm->suppressToken();
                $adminForm->addElement(new \Framework\Framework\Form\Type\Text('text_field', 'default value', true, 'label input text field', 'some description...'));
                $adminForm->addElement(new \Framework\Framework\Form\Type\Media('image_field', 'https://www.samplesource.com/images/get_free_samples.jpg', 'label image media field', 'some description...'));
                $adminForm->addElement(new \Framework\Framework\Form\Type\Media('media_field', 'cavolo', 'label generic media field', 'some description...'));
                $adminForm->addElement(new \Framework\Framework\Form\Type\Editor('editor_field', 'editor', 'label generic media field', 'some description...'));
                echo $render = $adminForm->render();
                ?>
            </div>
        </div>
        <div class="panel hidden" id="panel-2">
            <h3 class="panel-title">Panel Title2</h3>
            <div class="panel-content">
                <div class="ef-group">
                    <div class="ef-label">
                        <label for="">Label</label>
                    <span class="description">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                    </span>
                    </div>
                    <div class="ef-control">
                        <input type="text" class="jscolor" value="ab2567" />
                    </div>
                </div>
                <div class="ef-group">
                    <div class="ef-label">
                        <label for="">Label</label>
                    <span class="description">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                    </span>
                    </div>
                    <div class="ef-control">
                        <input type="text">
                    </div>
                </div>
                <div class="ef-group">
                    <div class="ef-label">
                        <label for="">Label</label>
                    <span class="description">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                    </span>
                    </div>
                    <div class="ef-control">
                        <input type="hidden" class="upload-value" name="sample" value="">
                        <button class="btn btn-upload">
                            <i class="fa fa-upload"></i> Upload
                        </button>
                        <span class="upload-file-path"></span>
                    </div>
                </div>
                <div class="ef-group">
                    <div class="ef-label">
                        <label for="">Label</label>
                    <span class="description">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                    </span>
                    </div>
                    <div class="ef-control">
                        <select name="" id="">
                            <option value="">dassddas</option>
                            <option value="">dassddas</option>
                            <option value="">dassddas</option>
                            <option value="">dassddas</option>
                        </select>
                    </div>
                </div>
                <div class="ef-group">
                    <div class="ef-label">
                        <label for="">Label</label>
                    <span class="description">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                    </span>
                    </div>
                    <div class="ef-control">
                        <p><input type="radio"> Radio</p>
                        <p><input type="radio"> Radio</p>
                        <p><input type="radio"> Radio</p>
                        <p><input type="radio"> Radio</p>
                    </div>
                </div>
                <div class="ef-group">
                    <div class="ef-label">
                        <label for="">Label</label>
                    <span class="description">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                    </span>
                    </div>
                    <div class="ef-control">
                        <p><input type="checkbox"> Checkbox</p>
                        <p><input type="checkbox"> Checkbox</p>
                        <p><input type="checkbox"> Checkbox</p>
                        <p><input type="checkbox"> Checkbox</p>
                    </div>
                </div>
                <div class="ef-group">
                    <div class="ef-label">
                        <label for="">Label</label>
                    <span class="description">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                    </span>
                    </div>
                    <div class="ef-control">
                        <textarea rows="10"></textarea>
                    </div>
                </div>
                <div class="ef-group">
                    <div class="ef-label">
                        <label for="">Label</label>
                    <span class="description">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                    </span>
                    </div>
                    <div class="ef-control">
                        <div id="editor" class="ef-editor"></div>
                    </div>
                </div>
                <div class="ef-buttons">
                    <button class="btn btn-save">
                        <i class="fa fa-save"></i>
                        <span>Save</span>
                    </button>
                    <button class="btn btn-reset">
                        <i class="fa fa-times"></i>
                        <span>Reset</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="panel hidden" id="panel-3">

        </div>
        <div class="panel hidden" id="panel-4">

        </div>
        <div class="panel hidden" id="panel-5">

        </div>


    </div>
</div>
<div class="copy">
    copyright <a href="#">E-Framework</a> by Easy Grafica
</div>