<?php

namespace Framework\Framework\Form\Type;

use Framework\Framework\Sluggify;
use Framework\Framework\Form\FormElementAbstract;
use Framework\Framework\WP\Image;

/**
 * This is the class to render media upload button.
 *
 * It should be used only in Wordpress admin panel.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Media extends FormElementAbstract
{
    /**
     * Submit constructor.
     *
     * @param $name
     * @param null $value
     */
    public function __construct($name, $value = null, $label = null, $description = null)
    {
        $this->setDefault($value);
        $this->addAttribute('name', $name);
        $this->addAttribute('id', Sluggify::generate($name));
        $this->addAttribute('value', $this->getDefault());
        $this->setLabel($label);
        $this->setDescription($description);
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $output = "<input type='hidden' class='upload-value' ";
        foreach ($this->getAllAttributes() as $key => $value) {
            $output .= $key."='".$value."' ";
        }
        $output .= '>';
        $class = '';
        if (Image::check($this->getDefault())) {
            $class .= ' margin-top-15';
        }
        $output .= "<a class='btn btn-upload media-upload{$class}'><i class='fa fa-upload'></i> Upload</a>";
        $output .= "<span class='upload-file-path'>";
        $output .= ($this->getDefault()) ? Image::renderForAdminPanel($this->getDefault()) : '';
        $output .= '</span>';

        return $output;
    }
}
