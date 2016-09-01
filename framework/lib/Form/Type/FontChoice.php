<?php

namespace Framework\Framework\Form\Type;

use Framework\Framework\Sluggify;
use Framework\Framework\Form\FormElementAbstract;
use Framework\Framework\Stringify;

/**
 * This is the class to render font select in a form.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class FontChoice extends FormElementAbstract
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
    public function __construct($name, $value = null, $required = null, $label = null, $description = null, $style = null)
    {
        $this->setDefault($value);
        $this->addAttribute('name', $name);
        $this->addAttribute('class', 'font-select\'');
        $this->addAttribute('id', Sluggify::generate($name));
        $this->addAttribute('value', $this->getDefault());
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
        $output = "<input type='text' ";
        foreach ($this->getAllAttributes() as $key => $value) {
            $output .= $key."='".$value."' ";
        }
        $output .= '>';
        $output .= '<span id="font-preview-'.$this->getAttribute('id').'" class="font-preview" style="font-family: \''.Stringify::removePlus($this->getDefault()).'\'">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</span>';

        return $output;
    }
}
