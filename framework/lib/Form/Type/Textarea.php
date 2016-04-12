<?php

namespace Framework\Framework\Form\Type;

use Framework\Framework\Sluggify;
use Framework\Framework\Form\FormElementAbstract;

/**
 * This is the class to render input text form.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Textarea extends FormElementAbstract
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
        $this->addAttribute('id', Sluggify::generate($name));
        $this->addAttribute('value', $value);
        $this->addAttribute('cols', 30);
        $this->addAttribute('rows', 8);
        $this->addAttribute('required', ($required) ? 'required' : '');
        $this->setLabel($label);
        $this->setStyle($style);
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $defaultValue = $this->getAttribute('value');
        $this->removeAttribute('value');

        $output = '<textarea ';
        foreach ($this->getAllAttributes() as $key => $value) {
            $output .= $key."='".$value."' ";
        }
        $output .= '>';
        $output .= $defaultValue;
        $output .= '</textarea>';

        return $output;
    }
}
