<?php

namespace Framework\Framework\Form\Type;

use Framework\Framework\Sluggify;
use Framework\Framework\Form\FormElementAbstract;

/**
 * This is the class to render input text form.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Choice extends FormElementAbstract
{
    /**
     * FormTextType constructor.
     *
     * @param $name
     * @param array $values
     * @param null  $required
     * @param null  $label
     * @param null  $style
     */
    public function __construct($name, $values = array(), $required = null, $label = null, $style = null)
    {
        $this->addAttribute('name', $name);
        $this->addAttribute('id', Sluggify::generate($name));
        $this->addValue('', ''); // blank default value
        $this->setValues($values);
        $this->addAttribute('required', ($required) ? 'required' : '');
        $this->setLabel($label);
        $this->setStyle($style);
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $output = '<select ';
        foreach ($this->getAllAttributes() as $key => $value) {
            $output .= $key."='".$value."' ";
        }
        $output .= '>';
        foreach ($this->getValues() as $key => $value) {
            $output .= '<option value="'.$value.'">'.$key.'</option>';
        }
        $output .= '</select>';

        return $output;
    }
}
