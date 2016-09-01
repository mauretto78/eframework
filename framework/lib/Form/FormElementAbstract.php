<?php

namespace Framework\Framework\Form;

use Framework\Framework\WP\Theme;

/**
 * This is the abstract class for all the form element classes.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
abstract class FormElementAbstract implements FormElementInterface
{
    /**
     * @var Theme
     */
    protected $theme;

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
    private $description;

    /**
     * @var string
     */
    private $style;

    /**
     * @var array
     */
    private $values = array();

    /**
     * @var string
     */
    private $default;

    /**
     * FormElementAbstract constructor.
     *
     * @param Theme $theme
     */
    public function __construct(Theme $theme)
    {
        $this->theme = $theme;
    }

    public function getTheme()
    {
        return $this->theme;
    }

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

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDescription()
    {
        return $this->description;
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

    public function setDefault($default)
    {
        $this->default = $default;
    }

    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @param $present
     * @param $value
     *
     * @return string
     */
    protected function _isSelected($present, $value)
    {
        if ($present == $value) {
            return ' selected="selected" ';
        }

        return '';
    }
}
