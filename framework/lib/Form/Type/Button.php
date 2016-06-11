<?php

namespace Framework\Framework\Form\Type;

use Framework\Framework\Sluggify;
use Framework\Framework\Form\FormElementAbstract;

/**
 * This is the class to render button form.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Button extends FormElementAbstract
{
    /**
     * Submit constructor.
     *
     * @param $name
     * @param null $value
     */
    public function __construct($name, $type = null, $style = null)
    {
        $this->addAttribute('name', $name);
        $this->addAttribute('id', Sluggify::generate($name));
        $this->addAttribute('type', ($type) ? $type : '');
        $this->setStyle($style);
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $output = '<button ';
        foreach ($this->getAllAttributes() as $key => $value) {
            $output .= $key."='".$value."' ";
        }
        $output .= '>';
        $output .= $this->getAttribute('name');
        $output .= '</button>';

        return $output;
    }
}
