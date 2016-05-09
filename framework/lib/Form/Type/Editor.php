<?php

namespace Framework\Framework\Form\Type;

use Framework\Framework\Sluggify;
use Framework\Framework\Form\FormElementAbstract;

/**
 * This is the class to render WP editor in a form.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Editor extends FormElementAbstract
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
        $this->addAttribute('class', 'tinymce-enabled');
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
        $output = "<div class='wp-editor-wrapper'>";
        $output .= '<textarea ';
        foreach ($this->getAllAttributes() as $key => $value) {
            $output .= $key."='".$value."' ";
        }
        $output .= '>';
        $output .= $this->getDefault();
        $output .= '</textarea>';
        $output .= '</div>';

        return $output;
    }
}
