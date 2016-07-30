<?php

namespace Framework\Framework\WP\Nav;

use Framework\Framework\WP\Admin\Admin;

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
    private $name;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Creates a navbar.
     *
     * @param $name
     * @return mixed
     */
    public function create($name)
    {
        $this->setName($name);

        return wp_create_nav_menu($name);
    }

    /**
     * Returns a navigation menu object.
     *
     * @return object|false False if $menu param isn't supplied or term does not exist, menu object if successful.
     */
    public function object()
    {
        return wp_get_nav_menu_object($this->getName());
    }

    /**
     * Assign the nav to a position.
     *
     * @param $position
     * @return mixed
     */
    public function assignTo($position)
    {
        $a = new Admin();
        $a->setOption('theme_mods_'.$a->getOption('stylesheet'), array( 'nav_menu_locations' => array($position => $this->object()->term_id)));
    }

    /**
     * Add an item to navbar.
     *
     * @param array $menu_item_data
     * @return mixed
     */
    public function addItem($menu_item_data = array())
    {
        $_POST['jw_nonce'] = wp_create_nonce('my-jw_nonce');

        return wp_update_nav_menu_item($this->object()->term_id, 0, $menu_item_data);
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
        $a = new Admin();

        if ($a->hasNavbar($l)) {
            wp_nav_menu($args);
        }
    }
}
