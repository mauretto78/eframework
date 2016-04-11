<?php

namespace Framework\Framework\Form;

use Framework\Framework\Sluggify;

/**
 * This is the class to render input text form.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class FormTextType extends FormElementAbstract
{
    /**
     * FormTextType constructor.
     *
     * @param $name
     * @param null $value
     * @param null $required
     * @param null $label
     * @param null $style
     */
    public function __construct($name, $value = null, $required = null, $label = null, $style = null)
    {
        $this->addAttribute('name', $name);
        $this->addAttribute('id', Sluggify::generateId($name));
        $this->addAttribute('value', $value);
        $this->addAttribute('required', ($required) ? 'required' : '');
        $this->setLabel($label);
        $this->setStyle($style);
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $output = "<input type='text' ";
        foreach ($this->getAllAttributes() as $key => $value) {
            $output .= $key."='".$value."' ";
        }
        $output .= '>';

        return $output;
    }
}
