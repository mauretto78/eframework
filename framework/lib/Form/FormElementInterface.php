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
     * Renders the form element.
     *
     * @return mixed
     */
    public function render();
}
