<?php

namespace Framework\Framework\Form\Type;

use Framework\Framework\Sluggify;
use Framework\Framework\Form\FormElementAbstract;

/**
 * This is the class to render radio button represented by icons in a form.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class IconChoice extends FormElementAbstract
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
        $output = '<div class="icon-choices clearfix">';
        foreach ($this->getValues() as $img => $data) {

            $value = $data[0];
            $label = $data[1];
            $id = $this->getAttribute('id').$value;

            if ($value === $this->getDefault()) {
                $checked = 'checked="checked" ';
                $active = ' active';
            } else {
                $checked = '';
                $active = '';
            }

            $output .= '<div class="icon-choice'.$active.'">';
            $output .= '<label for="'.$id.'"><img src="'.$img.'" class="icon-choice-img"></label>';
            $output .= '<input id="'.$id.'" type="radio" '.$checked.' name="'.$this->getAttribute('name').'" value="'.$value.'">';
            $output .= '<span class="icon-choice-label">'.$label.'</span>';
            $output .= '</div>';
        }
        $output .= '</div>';

        return $output;
    }
}