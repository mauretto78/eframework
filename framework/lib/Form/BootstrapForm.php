<?php

namespace Framework\Framework\Form;

/**
 * This class is a decorator for the base form.
 *
 * The class renders the form with bootstrap style.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class BootstrapForm extends BaseForm implements FormDecorator
{
    public function render()
    {
        $output = sprintf('<form action="%s" method="%s" %s>', $this->action, $this->method, $this->files);
        $output .= sprintf('<input type="hidden" name="_token" value="%s">', $this->token);

        foreach ($this->elements as $element) {
            $this->decorateElement($element);
            if ($element->getStyle() == 'horizontal') {
                $output .= $this->_renderBootstrapHorizontal($element);
            } else {
                $output .= $this->_renderBootstrapVertical($element);
            }
        }
        $output .= '</form>';

        return $output;
    }

    public function decorateElement(FormElementAbstract $element)
    {
        $element->addAttribute('class', 'form-control');
    }

    /**
     * Renders the element with a horizontal inline bootstrap style.
     *
     * @param FormElementAbstract $element
     *
     * @return string
     */
    private function _renderBootstrapHorizontal(FormElementAbstract $element)
    {
        switch (get_class($element)) {
            case 'Framework\\Framework\\Form\\Type\\Button':
                return $this->_renderBootstrapHorizontalButton($element);
                break;

            case 'Framework\\Framework\\Form\\Type\\Submit':
                return $this->_renderBootstrapHorizontalButton($element);
                break;

            default:
                return $this->_renderBootstrapHorizontalDefault($element);
                break;
        }
    }

    private function _renderBootstrapHorizontalDefault(FormElementAbstract $element)
    {
        $output = '<div class="form-group">';
        $output .= '<div class="row">';
        $output .= '<div class="col-sm-3 text-right">';
        $output .= ($element->getLabel()) ? "<label for='".@$element->getAttribute('id')."'>".$element->getLabel().'</label>' : '';
        $output .= '</div>';
        $output .= '<div class="col-sm-9">';
        $output .= $element->render();
        $output .= '</div>';
        $output .= '</div>';
        $output .= '</div>';

        return $output;
    }

    private function _renderBootstrapHorizontalButton(FormElementAbstract $element)
    {
        $output = '<div class="form-group">';
        $output .= '<div class="row">';
        $output .= '<div class="col-sm-3"></div>';
        $output .= '<div class="col-sm-9">';
        $output .= $element->render();
        $output .= '</div>';
        $output .= '</div>';
        $output .= '</div>';

        return $output;
    }

    /**
     * Renders the element with a vertical classic bootstrap style.
     *
     * @param FormElementAbstract $element
     *
     * @return string
     */
    private function _renderBootstrapVertical(FormElementAbstract $element)
    {
        switch (get_class($element)) {
            case 'Framework\\Framework\\Form\\Type\\Button':
                return $this->_renderBootstrapVerticalButton($element);
                break;

            case 'Framework\\Framework\\Form\\Type\\Submit':
                return $this->_renderBootstrapVerticalButton($element);
                break;

            default:
                return $this->_renderBootstrapVerticalDefault($element);
                break;
        }
    }

    private function _renderBootstrapVerticalDefault(FormElementAbstract $element)
    {
        $element->addAttribute('class', 'form-control');
        $output = '<div class="form-group">';
        $output .= ($element->getLabel()) ? "<label for='".@$element->getAttribute('id')."'>".$element->getLabel().'</label>' : '';
        $output .= $element->render();
        $output .= '</div>';

        return $output;
    }

    private function _renderBootstrapVerticalButton(FormElementAbstract $element)
    {
        $element->addAttribute('class', 'btn btn-default');
        $output = '<div class="form-group">';
        $output .= $element->render();
        $output .= '</div>';

        return $output;
    }
}
