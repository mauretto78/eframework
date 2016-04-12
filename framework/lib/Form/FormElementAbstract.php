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

    /**
     * @var array
     */
    private $values = array();

    public function addAttribute($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    public function getAttribute($name)
    {
        return $this->attributes[$name];
    }

    public function removeAttribute($name)
    {
        unset($this->attributes[$name]);
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

    public function addValue($key, $value)
    {
        $this->values[$key] = $value;
    }

    public function setValues($values)
    {
        if (!is_array($values)) {
            throw new \Exception('Array must be provided');
        }
        foreach ($values as $key => $value) {
            $this->addValue($key, $value);
        }
    }

    public function getValues()
    {
        return $this->values;
    }
}
