<?php

namespace Framework\Framework\WP\Nav;

use Framework\Framework\Parameters;

/**
 * This class renders WP navbars.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Nav
{
    /**
     * Generates the navbar.
     *
     * @param $label
     * @param $args
     */
    public function generate($label, $args)
    {
        if ($this->_exists($label)) {
            wp_nav_menu($args);
        }
    }

    /**
     * Register a navbar.
     *
     * @param $label
     * @param $name
     * @return bool
     */
    public function register($label, $name)
    {
        register_nav_menu($label, __($name, Parameters::get('app.name')));
    }

    /**
     * Checks if a navbar exists.
     *
     * @param $label
     * @return bool
     */
    private function _exists($label)
    {
        if (!has_nav_menu($label)) {
            return false;
        }
        return true;
    }
}