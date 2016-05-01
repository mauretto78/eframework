<?php

namespace Framework\Framework\Form;

/**
 * This is the base form.
 *
 * It can be decorated by using FormDecorator Interface.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
interface FormElementInterface
{
    /**
     * Adds an attribute to a form element.
     *
     * @param $name
     * @param $value
     *
     * @return mixed
     */
    public function addAttribute($name, $value);

    /**
     * Returns the value of an attribute of the form element.
     *
     * @return mixed
     */
    public function getAttribute($name);

    /**
     * Removes an attribute of the form element.
     *
     * @return mixed
     */
    public function removeAttribute($name);

    /**
     * Returns the attribute array of the form element.
     *
     * @return mixed
     */
    public function getAllAttributes();

    /**
     * Sets the label of the form element.
     *
     * @return mixed
     */
    public function setLabel($label);

    /**
     * Returns the label of the form element.
     *
     * @return mixed
     */
    public function getLabel();

    /**
     * Sets the description of the form element.
     *
     * @return mixed
     */
    public function setDescription($description);

    /**
     * Returns the description of the form element.
     *
     * @return mixed
     */
    public function getDescription();

    /**
     * Sets the style of the form element.
     *
     * @return mixed
     */
    public function setStyle($style);

    /**
     * Returns the style of the form element. Default = vertical [horizontal, vertical].
     *
     * @return mixed
     */
    public function getStyle();

    /**
     * Adds a value to $values array.
     *
     * @param $key
     * @param $value
     *
     * @return mixed
     */
    public function addValue($key, $value);

    /**
     * Sets $values with an array.
     *
     * @param $values
     *
     * @return mixed
     */
    public function setValues($values);

    /**
     * Returns the values array.
     *
     * @return mixed
     */
    public function getValues();

    /**
     * Sets the default value of the element.
     *
     * @param $default
     *
     * @return mixed
     */
    public function setDefault($default);

    /**
     * Returns the default value.
     *
     * @return mixed
     */
    public function getDefault();

    /**
     * Renders the form element.
     *
     * @return mixed
     */
    public function render();
}
