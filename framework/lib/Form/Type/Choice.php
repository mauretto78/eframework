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
     * Choice constructor.
     *
     * @param $name
     * @param array $values
     * @param null  $required
     * @param null  $label
     * @param null  $description
     * @param null  $style
     */
    public function __construct($name, $values = array(), $value = null, $required = null, $label = null, $description = null, $style = null)
    {
        $this->setDefault($value);
        $this->addAttribute('name', $name);
        $this->addAttribute('id', Sluggify::generate($name));
        $this->addValue('', ''); // blank default value
        $this->setValues($values);
        ($required) ? $this->addAttribute('required', 'required') : null;
        $this->setLabel($label);
        $this->setDescription($description);
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
            $output .= '<option ';
            if ($value and $value == $this->getDefault()) {
                $output .= 'selected="selected" ';
            }
            $output .= 'value="'.$key.'">'.$value.'</option>';
        }
        $output .= '</select>';

        return $output;
    }
}
