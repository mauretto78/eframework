<?php

use Framework\Framework\Form\BaseForm;
use Framework\Framework\Form\BootstrapForm;

class FormTest extends PHPUnit_Framework_TestCase
{
    protected $baseForm;
    protected $bootstrapForm;

    public function setUp()
    {
        $this->baseForm = new BaseForm();
        $this->bootstrapForm = new BootstrapForm();
    }

    public function testRenderBaseForm()
    {
        $this->baseForm->setToken(12345678); // WARNING: Never use this!!!....only for test
        $this->baseForm->addElement(new \Framework\Framework\Form\Type\Text('first_name'));
        $this->baseForm->addElement(new \Framework\Framework\Form\Type\Text('last_name'));
        $this->baseForm->addElement(new \Framework\Framework\Form\Type\Choice('gender', array('M' => 'Male', 'F' => 'Female')));
        $this->baseForm->addElement(new \Framework\Framework\Form\Type\Textarea('notes'));
        $render = $this->baseForm->render();

        $this->assertContains('<form action="" method="post" ><input type=\'text\' name=\'first_name\' id=\'first-name\' value=\'\' required=\'\' ><input type=\'text\' name=\'last_name\' id=\'last-name\' value=\'\' required=\'\' ><select name=\'gender\' id=\'gender\' required=\'\' ><option value=""></option><option value="Male">M</option><option value="Female">F</option></select><textarea name=\'notes\' id=\'notes\' cols=\'30\' rows=\'8\' required=\'\' ></textarea><input type="hidden" name="_token" value="12345678"></form>', $render);
    }

    public function testRenderBootstrapForm()
    {
        $this->bootstrapForm->setToken(12345678); // WARNING: Never use this!!!....only for test
        $this->bootstrapForm->addElement(new \Framework\Framework\Form\Type\Text('first_name'));
        $this->bootstrapForm->addElement(new \Framework\Framework\Form\Type\Text('last_name'));
        $this->bootstrapForm->addElement(new \Framework\Framework\Form\Type\Choice('gender', array('M' => 'Male', 'F' => 'Female')));
        $this->bootstrapForm->addElement(new \Framework\Framework\Form\Type\Textarea('notes'));
        $render = $this->bootstrapForm->render();

        $this->assertContains('<form action="" method="post" ><input type="hidden" name="_token" value="12345678"><div class="form-group"><input type=\'text\' name=\'first_name\' id=\'first-name\' value=\'\' required=\'\' class=\'form-control\' ></div><div class="form-group"><input type=\'text\' name=\'last_name\' id=\'last-name\' value=\'\' required=\'\' class=\'form-control\' ></div><div class="form-group"><select name=\'gender\' id=\'gender\' required=\'\' class=\'form-control\' ><option value=""></option><option value="Male">M</option><option value="Female">F</option></select></div><div class="form-group"><textarea name=\'notes\' id=\'notes\' cols=\'30\' rows=\'8\' required=\'\' class=\'form-control\' ></textarea></div></form>', $render);
    }
}
