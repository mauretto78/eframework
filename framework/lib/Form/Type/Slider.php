<?php

namespace Framework\Framework\Form\Type;

use Framework\Framework\Sluggify;
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
    public function __construct($name, $value = null, $required = null, $label = null, $description = null)
    {
        $this->setDefault($value);
        $this->addAttribute('name', $name);
        $this->addAttribute('id', Sluggify::generate($name));
        $this->addAttribute('value', $this->getDefault());
        ($required) ? $this->addAttribute('required', 'required') : null;
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
        $output .= '<div id="ef-slider-sortable"></div>';

        return $output;
    }
}
?>

<!--
<div id="ef-slider-sortable">
                            <div id="slide-1" class="ef-slide clearfix">
                                <div class="ef-slide-delete"><i class="fa fa-close"></i></div>
                                <div class="ef-slide-img">img</div>
                                <div class="ef-slide-text">
                                    <h4>Testo della slide</h4>
                                    <span class="description">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem, labore, sit.
                                    </span>
                                    <a href="#">Testo del link</a>
                                </div>
                            </div>
                            <div id="slide-2" class="ef-slide clearfix">
                                <div class="ef-slide-delete"><i class="fa fa-close"></i></div>
                                <div class="ef-slide-img">img</div>
                                <div class="ef-slide-text">
                                    <h4>Testo della slide 2</h4>
                                <span class="description">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem, labore, sit.
                                </span>
                                    <a href="#">Testo del link</a>
                                </div>
                            </div>
                            <div id="slide-3" class="ef-slide clearfix">
                                <div class="ef-slide-delete"><i class="fa fa-close"></i></div>
                                <div class="ef-slide-img">img</div>
                                <div class="ef-slide-text">
                                    <h4>Testo della slide 3</h4>
                                <span class="description">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem, labore, sit.
                                </span>
                                    <a href="#">Testo del link</a>
                                </div>
                            </div>
                        </div>-->