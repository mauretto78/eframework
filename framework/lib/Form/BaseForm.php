<?php

namespace Framework\Framework\Form;

/**
 * This is the base form class.
 *
 * It renders the form; a token against CSRF attaks is automatically generated.
 *
 * It can be decorated by using FormDecorator Interface.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class BaseForm
{
    /**
     * @var string
     */
    protected $action;

    /**
     * @var string
     */
    protected $method;

    /**
     * @var bool
     */
    protected $files;

    /**
     * @var string
     */
    protected $token;

    /**
     * @var array
     */
    protected $elements = array();

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $output;

    /**
     * BaseForm constructor.
     *
     * @param string $action
     * @param string $method
     * @param bool   $files
     */
    public function __construct($action = '', $method = 'post', $files = false, $name = null)
    {
        $this->action = $action;
        $this->method = $method;
        $this->files = ($files) ? "enctype='multipart/form-data'" : '';
        $this->name = $name;
        $this->token = $this->_generateToken();
    }

    /**
     * Adds an element to the form.
     *
     * @param FormElementInterface $formElementInterface
     *
     * @return $this
     */
    public function addElement(FormElementInterface $formElementInterface)
    {
        $this->elements[] = $formElementInterface;
    }

    /**
     * Sets the token for form.
     *
     * WARNING: Use only for test purposes!!!
     *
     * @return string
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * Sets the token blank.
     *
     * Use for AJAX requests.
     */
    public function suppressToken()
    {
        $this->token = null;
    }

    public function setOutput()
    {
        $output = sprintf('<form action="%s" method="%s" name="%s" %s>', $this->action, $this->method, $this->name, $this->files);
        foreach ($this->elements as $element) {
            $output .= ($element->getLabel()) ? "<label for='".@$element->getAttribute('id')."'>".$element->getLabel().'</label>' : '';
            $output .= $element->render();
        }
        $output .= ($this->token) ? sprintf('<input type="hidden" name="token" value="%s">', $this->token) : '';
        $output .= '</form>';

        $this->output = $output;

        return $this;
    }

    public function getOutput()
    {
        return $this->output;
    }

    public function render()
    {
        echo $this->output;
    }

    /**
     * Generates the token to protect form from CSRF attaks.
     */
    private function _generateToken()
    {
        $token = new Token();

        return $token->generate();
    }
}
