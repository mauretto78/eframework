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
