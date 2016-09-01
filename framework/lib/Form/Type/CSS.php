<?php

namespace Framework\Framework\Form\Type;

use Framework\Framework\Sluggify;
use Framework\Framework\Form\FormElementAbstract;

/**
 * This is the class to render CSS ide form.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class CSS extends FormElementAbstract
{
    /**
     * CSS constructor.
     *
     * @param $name
     * @param null $value
     * @param null $required
     * @param null $label
     * @param null $description
     * @param null $style
     */
    public function __construct($name, $value = null, $label = null, $description = null, $style = null)
    {
        $this->setDefault($value);
        $this->addAttribute('name', $name);
        $this->addAttribute('id', Sluggify::generate($name));
        $this->addAttribute('class', 'ace-textarea');
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
        $output .= '<div id="editor" class="ef-editor">';
        $output .= $this->getDefault();
        $output .= '</div>';

        return $output;
    }
}
