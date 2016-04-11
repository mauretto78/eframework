<?php

namespace Framework\Framework\Form;

/**
 * This is the abstract class for all the form element classes.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
abstract class FormElementAbstract implements FormElementInterface
{
    /**
     * @var array
     */
    private $attributes = array();

    /**
     * @var string
     */
    private $label;

    /**
     * @var string
     */
    private $style;

    public function addAttribute($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    public function getAttribute($name)
    {
        return $this->attributes[$name];
    }

    public function getAllAttributes()
    {
        return $this->attributes;
    }

    public function setLabel($label)
    {
        $this->label = $label;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function setStyle($style)
    {
        $this->style = $style;
    }

    public function getStyle()
    {
        return $this->style;
    }
}
