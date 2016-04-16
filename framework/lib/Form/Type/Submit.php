<?php

namespace Framework\Framework\Form\Type;

use Framework\Framework\Sluggify;
use Framework\Framework\Form\FormElementAbstract;

/**
 * This is the class to render input text form.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Submit extends FormElementAbstract
{
    /**
     * Submit constructor.
     *
     * @param $name
     * @param null $value
     */
    public function __construct($name, $value = null, $style = null)
    {
        $this->addAttribute('name', $name);
        $this->addAttribute('id', Sluggify::generate($name));
        $this->addAttribute('value', ($value) ? $value : $name);
        $this->setStyle($style);
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $output = "<input type='submit' ";
        foreach ($this->getAllAttributes() as $key => $value) {
            $output .= $key."='".$value."' ";
        }
        $output .= '>';

        return $output;
    }
}
