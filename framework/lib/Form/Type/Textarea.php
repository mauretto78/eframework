<?php

namespace Framework\Framework\Form\Type;

use Framework\Framework\Sluggify;
use Framework\Framework\Form\FormElementAbstract;

/**
 * This is the class to render textarea form.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Textarea extends FormElementAbstract
{
    /**
     * Textarea constructor.
     *
     * @param $name
     * @param null $value
     * @param null $required
     * @param null $label
     * @param null $description
     * @param null $style
     */
    public function __construct($name, $value = null, $required = null, $label = null, $description = null, $style = null)
    {
        $this->setDefault($value);
        $this->addAttribute('name', $name);
        $this->addAttribute('id', Sluggify::generate($name));
        $this->addAttribute('cols', 30);
        $this->addAttribute('rows', 8);
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
        $output = '<textarea ';
        foreach ($this->getAllAttributes() as $key => $value) {
            $output .= $key."='".$value."' ";
        }
        $output .= '>';
        $output .= $this->getDefault();
        $output .= '</textarea>';

        return $output;
    }
}
