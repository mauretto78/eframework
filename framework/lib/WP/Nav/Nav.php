<?php

namespace Framework\Framework\WP\Nav;

/**
 * This class renders WP navbars.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Nav
{
    /**
     * @var string
     */
    private $label;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * Creates a navbar.
     *
     * @param $label
     * @param $description
     * @param array $args
     */
    public function create($label, $name, $description)
    {
        $this->label = $label;
        $this->name = $name;
        $this->description = $description;

        $this->register();
    }

    /**
     * Register a navbar.
     *
     * @return bool
     */
    public function register()
    {
        register_nav_menus(array(
            $this->label => __($this->name, $this->description),
        ));
    }

    /**
     * Renders the navbar.
     *
     * @param null  $label
     * @param array $args
     */
    public function render($label = null, $args = array())
    {
        $l = ($label) ? $label : $this->label;

        if ($this->exists($l)) {
            wp_nav_menu($args);
        }
    }

    /**
     * Checks if a navbar exists.
     *
     * @param $label
     *
     * @return bool
     */
    public function exists($label)
    {
        return has_nav_menu($label);
    }
}
