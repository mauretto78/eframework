<?php

namespace Framework\Framework\Form\Type;

use Framework\Framework\Form\FormElementAbstract;

/**
 * This is the class to render checkbox in a form.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Checkbox extends FormElementAbstract
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
    public function __construct($name, $values = array(), $value = array(), $required = null, $label = null, $description = null, $style = null)
    {
        $this->setDefault($value);
        $this->addAttribute('name', $name);
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
        $output = '';

        foreach ($this->getValues() as $key => $value) {
            if (@in_array($value, $this->getDefault())) {
                $checked = 'checked="checked" ';
            } else {
                $checked = '';
            }
            $output .= '<p><input type="checkbox" '.$checked.' name="'.$this->getAttribute('name').'[]" value="'.$value.'"> '.$key.'</p>';
        }

        return $output;
    }
}
