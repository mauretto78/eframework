<?php

namespace Framework\Framework\Form\Type;

use Framework\Framework\Serializer;
use Framework\Framework\WP\Admin\Admin;
use Framework\Framework\Form\FormElementAbstract;

/**
 * This is the class to render a special slider sortable panel.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Slider extends FormElementAbstract
{
    /**
     * Text constructor.
     *
     * @param $name
     * @param null $value
     * @param null $required
     * @param null $label
     * @param null $description
     * @param null $style
     */
    public function __construct($name, $label = null, $description = null)
    {
        $this->setLabel($label);
        $this->setDescription($description);
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $output = '<div class="slide-controls">';
        $output .= '<a href="#" class="add-slide"><i class="fa fa-plus"></i> Add a slide</a>';
        $output .= '</div>';
        $output .= '<div id="ef-slider-sortable">'.$this->_convertData(new Admin()).'</div>';

        return $output;
    }

    /**
     * Unserialize data and transform it to an array.
     *
     * @param Admin $admin
     *
     * @return mixed
     */
    private function _convertData(Admin $admin)
    {
        $output = '';

        $data = array(
            $admin->getOption('ef-slide-img'),
            $admin->getOption('ef-slide-title'),
            $admin->getOption('ef-slide-caption'),
            $admin->getOption('ef-slide-link'),
        );

        $count = count(Serializer::unserialize($admin->getOption('ef-slide-img')));

        $convertedData = Serializer::merge($data, $count);

        foreach ($convertedData as $items) {
            $output .= '<div class="ef-slide clearfix">';
            $output .= '<div class="ef-slide-delete"><i class="fa fa-close"></i></div>';
            $output .= '<input type="hidden" name="ef-slide-img[]" value="'.$items[0].'" class="ef-slide-img-value">';
            $output .= '<div class="ef-slide-img"><div class="thumbnail" style="background-image: url(\''.$items[0].'\');"><span title="delete this image" class="thumbnail-delete delete-file"><i class="fa fa-times"></i></span></div></div>';
            $output .= '<div class="ef-slide-text">';
            $output .= '<input type="text" name="ef-slide-title[]" value="'.$items[1].'" class="ef-slide-input" placeholder="title here">';
            $output .= '<textarea rows="4" name="ef-slide-caption[]" class="ef-slide-textarea" placeholder="caption here">'.$items[2].'</textarea>';
            $output .= '<input type="text" name="ef-slide-link[]" value="'.$items[3].'" class="ef-slide-link" placeholder="link here">';
            $output .= '</div>';
            $output .= '</div>';
        }

        return $output;
    }
}
