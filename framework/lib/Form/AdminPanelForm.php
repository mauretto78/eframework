<?php

namespace Framework\Framework\Form;

/**
 * This class is a decorator for the base form.
 *
 * The class renders the form with bootstrap style.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */

class AdminPanelForm extends BaseForm implements FormDecorator
{

    public function render()
    {
        $output = sprintf('<form action="%s" method="%s" name="%s" %s>', $this->action, $this->method, $this->name, $this->files);

        foreach ($this->elements as $element) {
            $output .= $this->_renderAdminPanelElement($element);
        }
        $output .= ($this->token) ? sprintf('<input type="hidden" name="token" value="%s">', $this->token) : '';
        $output .= '</form>';

        return $output;
    }

    public function decorateElement(FormElementAbstract $element)
    {
        return $this; // No decoration needed.
    }

    /**
     * Renders the element with the custom admin panel style.
     *
     * @param FormElementAbstract $element
     *
     * @return string
     */
    private function _renderAdminPanelElement(FormElementAbstract $element)
    {
        $output = '<div class="ef-group">';
        $output .= '<div class="ef-label">';
        $output .= ($element->getLabel()) ? "<label for='".@$element->getAttribute('id')."'>".$element->getLabel().'</label>' : '';
        $output .= ($element->getDescription()) ? '<span class="description">'.$element->getDescription().'</span>' : '';
        $output .= '</div>';
        $output .= '<div class="ef-control">';
        $output .= $element->render();
        $output .= '</div>';
        $output .= '</div>';

        return $output;
    }
}
