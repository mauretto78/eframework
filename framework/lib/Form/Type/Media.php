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
        if ($this->_isImage($this->getDefault())) {
            $class .= ' margin-top-15';
        }
        $output .= "<a class='btn btn-upload{$class}'><i class='fa fa-upload'></i> Upload</a>";
        $output .= "<span class='upload-file-path'>";
        $output .= ($this->getDefault()) ? $this->_renderFile($this->getDefault()) : '';
        $output .= '</span>';

        return $output;
    }

    /**
     * Renders an image or a text link.
     *
     * @param $path
     */
    private function _renderFile($path)
    {
        if ($this->_isImage($path)) {
            $output = '<div class="thumbnail" style="background-image: url(\''.$path.'\');"><span title="delete this image" class="thumbnail-delete delete-file"><i class="fa fa-times"></i></span></div>';
        } else {
            $output = '<span class="uploaded-file" href="'.$path.'" target="_blank">'.$path.'</span> <br><a href="#" class="delete-file">Delete this file</a>';
        }

        return $output;
    }

    /**
     * Returns if a file is an image.
     *
     * @TODO Move to a separate class.
     *
     * @param $img
     *
     * @return bool
     */
    private function _isImage($file)
    {
        if (@is_array(getimagesize($file))) {
            return true;
        }

        return false;
    }
}
