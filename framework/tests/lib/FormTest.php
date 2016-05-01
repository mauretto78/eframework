<?php

use Framework\Framework\Form\BaseForm;
use Framework\Framework\Form\BootstrapForm;
use Framework\Framework\Form\AdminPanelForm;

class FormTest extends PHPUnit_Framework_TestCase
{
    protected $baseForm;
    protected $bootstrapForm;
    protected $adminForm;

    public function setUp()
    {
        $this->baseForm = new BaseForm();
        $this->bootstrapForm = new BootstrapForm();
        $this->adminForm = new AdminPanelForm('','POST','','admin-form');
    }

    public function testNoTokenGenerated()
    {
        $this->baseForm->suppressToken();
        $render = $this->baseForm->render();

        $this->assertEquals($render, '<form action="" method="post" name="" ></form>');
    }

    public function testRenderBaseForm()
    {
        $this->baseForm->setToken(12345678); // WARNING: Never use this!!!....only for test
        $this->baseForm->addElement(new \Framework\Framework\Form\Type\File('file'));
        $this->baseForm->addElement(new \Framework\Framework\Form\Type\Text('first_name'));
        $this->baseForm->addElement(new \Framework\Framework\Form\Type\Text('last_name'));
        $this->baseForm->addElement(new \Framework\Framework\Form\Type\Choice('gender', array('M' => 'Male', 'F' => 'Female')));
        $this->baseForm->addElement(new \Framework\Framework\Form\Type\Textarea('notes'));
        $this->baseForm->addElement(new \Framework\Framework\Form\Type\Button('send us request'));
        $render = $this->baseForm->render();

        $this->assertEquals('<form action="" method="post" name="" ><input type=\'file\' name=\'file\' id=\'file\' ><input type=\'text\' name=\'first_name\' id=\'first-name\' value=\'\' ><input type=\'text\' name=\'last_name\' id=\'last-name\' value=\'\' ><select name=\'gender\' id=\'gender\' ><option value=""></option><option value="Male">M</option><option value="Female">F</option></select><textarea name=\'notes\' id=\'notes\' cols=\'30\' rows=\'8\' ></textarea><button name=\'send us request\' id=\'send-us-request\' type=\'\' >send us request</button><input type="hidden" name="token" value="12345678"></form>', $render);
    }

    public function testRenderBootstrapVerticalForm()
    {
        $this->bootstrapForm->setToken(12345678); // WARNING: Never use this!!!....only for test
        $this->bootstrapForm->addElement(new \Framework\Framework\Form\Type\Text('first_name'));
        $this->bootstrapForm->addElement(new \Framework\Framework\Form\Type\Text('last_name'));
        $this->bootstrapForm->addElement(new \Framework\Framework\Form\Type\Choice('gender', array('M' => 'Male', 'F' => 'Female')));
        $this->bootstrapForm->addElement(new \Framework\Framework\Form\Type\Textarea('notes'));
        $this->bootstrapForm->addElement(new \Framework\Framework\Form\Type\Button('send'));
        $render = $this->bootstrapForm->render();

        $this->assertEquals('<form action="" method="post" name="" ><div class="form-group"><input type=\'text\' name=\'first_name\' id=\'first-name\' value=\'\' class=\'form-control\' ></div><div class="form-group"><input type=\'text\' name=\'last_name\' id=\'last-name\' value=\'\' class=\'form-control\' ></div><div class="form-group"><select name=\'gender\' id=\'gender\' class=\'form-control\' ><option value=""></option><option value="Male">M</option><option value="Female">F</option></select></div><div class="form-group"><textarea name=\'notes\' id=\'notes\' cols=\'30\' rows=\'8\' class=\'form-control\' ></textarea></div><div class="form-group"><button name=\'send\' id=\'send\' type=\'\' class=\'btn btn-default\' >send</button></div><input type="hidden" name="token" value="12345678"></form>', $render);
    }

    public function testRenderBootstrapHorizontalForm()
    {
        $this->bootstrapForm->setToken(12345678); // WARNING: Never use this!!!....only for test
        $this->bootstrapForm->addElement(new \Framework\Framework\Form\Type\Text('first_name', '', '', 'label first name', 'some description...', 'horizontal'));
        $this->bootstrapForm->addElement(new \Framework\Framework\Form\Type\Text('last_name', '', '', 'label last name', 'some description...', 'horizontal'));
        $this->bootstrapForm->addElement(new \Framework\Framework\Form\Type\Choice('gender', array('M' => 'Male', 'F' => 'Female'), 'Female', true, 'label gender name', 'some description...', 'horizontal'));
        $this->bootstrapForm->addElement(new \Framework\Framework\Form\Type\Textarea('notes', '', '', 'label first name', 'some description...', 'horizontal'));
        $this->bootstrapForm->addElement(new \Framework\Framework\Form\Type\Button('invia', '', 'horizontal'));
        $render = $this->bootstrapForm->render();

        $this->assertEquals('<form action="" method="post" name="" ><div class="form-group"><div class="row"><div class="col-sm-3 text-right"><label for=\'first-name\'>label first name</label></div><div class="col-sm-9"><input type=\'text\' name=\'first_name\' id=\'first-name\' value=\'\' class=\'form-control\' ></div></div></div><div class="form-group"><div class="row"><div class="col-sm-3 text-right"><label for=\'last-name\'>label last name</label></div><div class="col-sm-9"><input type=\'text\' name=\'last_name\' id=\'last-name\' value=\'\' class=\'form-control\' ></div></div></div><div class="form-group"><div class="row"><div class="col-sm-3 text-right"><label for=\'gender\'>label gender name</label></div><div class="col-sm-9"><select name=\'gender\' id=\'gender\' required=\'required\' class=\'form-control\' ><option value=""></option><option value="Male">M</option><option selected="selected" value="Female">F</option></select></div></div></div><div class="form-group"><div class="row"><div class="col-sm-3 text-right"><label for=\'notes\'>label first name</label></div><div class="col-sm-9"><textarea name=\'notes\' id=\'notes\' cols=\'30\' rows=\'8\' class=\'form-control\' ></textarea></div></div></div><div class="form-group"><div class="row"><div class="col-sm-3"></div><div class="col-sm-9"><button name=\'invia\' id=\'invia\' type=\'\' class=\'form-control\' >invia</button></div></div></div><input type="hidden" name="token" value="12345678"></form>', $render);
    }

    public function testAdminPanelForm()
    {
        $this->adminForm->suppressToken();
        $this->adminForm->addElement(new \Framework\Framework\Form\Type\Text('text_field', 'default value', true, 'label input text field', 'some description...'));
        $this->adminForm->addElement(new \Framework\Framework\Form\Type\Media('media_field', 'default value', 'label input text field', 'some description...'));
        echo $render = $this->adminForm->render();
    }
}
