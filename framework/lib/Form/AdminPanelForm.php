<?php

namespace Framework\Framework\Form;

use Framework\Framework\WP\Path;

/**
 * This class is a decorator for the base form.
 *
 * The class renders the form with bootstrap style.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class AdminPanelForm extends BaseForm implements FormDecorator
{
    private $ajaxAction;

    /**
     * AdminPanelForm constructor.
     */
    public function __construct($action)
    {
        parent::__construct();
        $this->action = Path::admin('admin-ajax.php');
        $this->ajaxAction = $action;
    }

    public function setOutput()
    {
        $output = sprintf('<form action="%s" class="wordpress-ajax-form" method="%s" name="%s" %s>', $this->action, $this->method, $this->name, $this->files);

        foreach ($this->elements as $element) {
            $output .= $this->_renderAdminPanelElement($element);
        }

        $output .= $this->_renderButtons();
        $output .= '<input type="hidden" class="wordpress-ajax-form-action" name="action" value="'.$this->ajaxAction.'">';
        $output .= wp_nonce_field($this->ajaxAction.'_nonce_action', $this->ajaxAction.'_nonce_field', true, false);
        $output .= '</form>';

        $this->output = $output;

        return $this;
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
        $output .= '<div class="ef-control clearfix">';
        $output .= $element->render();
        $output .= '</div>';
        $output .= '</div>';

        return $output;
    }

    /**
     * Renders the form buttons.
     *
     * @return string
     */
    private function _renderButtons()
    {
        $output = '<div class="ef-buttons">';
        $output .= '<button type="submit" class="btn btn-lg btn-save"><i id="loading-spinner" class="fa fa-circle-o-notch fa-spin hidden"></i> <span>Save</span></button>';
        $output .= '<a class="btn btn-lg btn-reset"><span>Reset</span></a>';
        $output .= '</div>';

        return $output;
    }
}
