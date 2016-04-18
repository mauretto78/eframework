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
     * BaseForm constructor.
     *
     * @param string $action
     * @param string $method
     * @param bool   $files
     */
    public function __construct($action = '', $method = 'post', $files = false)
    {
        $this->action = $action;
        $this->method = $method;
        $this->files = ($files) ? "enctype='multipart/form-data'" : '';
        $this->token = $this->_generateToken();
    }

    /**
     * Adds an element to the form.
     *
     * @param FormElementInterface $formElementInterface
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

    /**
     * Renders the form.
     *
     * @return string
     */
    public function render()
    {
        $output = sprintf('<form action="%s" method="%s" %s>', $this->action, $this->method, $this->files);
        foreach ($this->elements as $element) {
            $output .= $element->render();
        }
        $output .= ($this->token) ? sprintf('<input type="hidden" name="token" value="%s">', $this->token) : '';
        $output .= '</form>';

        return $output;
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
