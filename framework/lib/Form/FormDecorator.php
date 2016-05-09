<?php

namespace Framework\Framework\Form;

/**
 * This interface decorates the Base FormRender.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
interface FormDecorator
{
    /**
     * Set the output for the form.
     *
     * @return string
     */
    public function setOutput();

    /**
     * Get the output for the form.
     *
     * @return string
     */
    public function getOutput();

    /**
     * Renders the form.
     *
     * @return mixed
     */
    public function render();

    /**
     * Decorates the element of the form with the proper style.
     *
     * @return mixed
     */
    public function decorateElement(FormElementAbstract $element);
}
