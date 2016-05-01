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
    public function __construct($name, $value = null, $required = null, $label = null, $description = null)
    {
        $this->setDefault($value);
        $this->addAttribute('name', $name);
        $this->addAttribute('id', Sluggify::generate($name));
        ($required) ? $this->addAttribute('required', 'required') : null;
        $this->setLabel($label);
        $this->setDescription($description);
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $output = "<div class='wp-editor-wrapper'>";
        $output .= wp_editor($this->getDefault(), $this->getAttribute('id'), array('textarea_name' => $this->getAttribute('id'), 'media_buttons' => false));
        $output .= "</div>";

        return $output;
    }
}
