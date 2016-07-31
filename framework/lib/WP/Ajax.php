<?php

namespace Framework\Framework\WP;

use Framework\Framework\Session\SessionBridge;
use Framework\Framework\WP\Theme;

/**
 * This class handles data from ajax WP requests.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Ajax
{
    /**
     * @var
     */
    private $name;

    /**
     * @var
     */
    private $data;

    /**
     * Ajax constructor.
     *
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Handles the ajax request.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->_parse(new SessionBridge());

        $checkNonce = $this->_checkNonce($this->data[$this->name.'_nonce_field'], $this->name.'_nonce_action');

        switch ($checkNonce) {
            case 1:
                $this->removeData('action');
                $this->removeData($this->name.'_nonce_field');

                return $this->_save(new Theme());
                break;
            case 2:
                return 'Nonce is between 12 and 24 hours old';
                break;
            default:
                return  'Nonce is invalid';
        }
    }

    /**
     * Gets data.
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Removes data.
     *
     * @param $key
     */
    public function removeData($key)
    {
        unset($this->data[$key]);
    }

    /**
     * Parses the data from ajax request and returns an array.
     *
     * @param SessionBridge $session
     *
     * @return array
     */
    private function _parse(SessionBridge $session)
    {
        $data = $session->getRequest()->request->get('data');
        $parseArray = array();
        parse_str($data, $parseArray);

        return $this->data = $parseArray;
    }

    /**
     * Checks if a nonce is valid.
     *
     * @param $nonce
     * @param $action
     *
     * @return bool
     */
    private function _checkNonce($nonce, $action)
    {
        if (!isset($nonce) || !wp_verify_nonce($nonce, $action)) {
            return false;
        }

        return true;
    }

    /**
     * Saves data.
     *
     * @param Theme $theme
     *
     * @return bool
     */
    private function _save(Theme $theme)
    {
        foreach ($this->getData() as $key => $value) {
            if ($theme->getOption($key) !== $value) {
                $theme->setOption($key, $value);
            }
        }

        return true;
    }
}
