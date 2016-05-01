<?php

namespace Framework\Framework\Form\Type;

use Framework\Framework\Sluggify;
use Framework\Framework\Form\FormElementAbstract;

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
        $output .= "<a class='btn btn-upload'><i class='fa fa-upload'></i> Upload</a>";
        $output .= "<span class='upload-file-path'>";
        $output .= ($this->getDefault()) ? $this->_renderFile($this->getDefault()): '';
        $output .= "</span>";

        return $output;
    }

    /**
     * Renders an image or a text link.
     *
     * @param $path
     */
    private function _renderFile($path)
    {
        if(@is_array(getimagesize($path))){
            $output = "immagine";
        } else {
            $output = '<a class="uploaded-file" href="'.$path.'" target="_blank">'.$path.'</a>';
        }

        return $output;
    }
}
