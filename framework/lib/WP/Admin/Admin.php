<?php

namespace Framework\Framework\WP\Admin;

/**
 * This class handles admin pages, options and sidebars in WP panel.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Admin
{
    /**
     * @var array
     */
    private $options = array();

    /**
     * @var array
     */
    private $pages = array();

    /**
     * @var array
     */
    private $sidebars = array();

    /**
     * Admin constructor.
     *
     * Load all the WP options.
     */
    public function __construct()
    {
        $this->options = wp_load_alloptions();
    }

    /**
     * Sets an option.
     *
     * @param $option
     * @param $value
     *
     * @return bool
     */
    public function setOption($option, $value)
    {
        $this->options[$option] = $value;

        return update_option($option, $value, true);
    }

    /**
     * Gets the value of an option.
     *
     * @param $option
     *
     * @return mixed
     */
    public function getOption($option)
    {
        return $this->options[$option];
    }

    /**
     * Checks if exists an option.
     *
     * @param $option
     *
     * @return bool
     */
    public function hasOption($option)
    {
        return (@$this->options[$option]) ? true : false;
    }

    /**
     * Returns all the options.
     *
     * @param $option
     *
     * @return mixed
     */
    public function getAllOptions()
    {
        return $this->options;
    }

    /**
     * Returns the count of options.
     *
     * @param $option
     *
     * @return mixed
     */
    public function getCountOptions()
    {
        return count($this->options);
    }

    /**
     * Adds a page in WP panel.
     *
     * @param AdminPage $page
     *
     * @return AdminPage
     */
    public function addPage(AdminPage $page)
    {
        $this->pages[] = $page;

        return $page;
    }

    /**
     * Returns the count of pages.
     *
     * @return int
     */
    public function getCountPages()
    {
        return count($this->pages);
    }

    /**
     * Register a sidebar.
     *
     * @param $name
     * @param $id
     * @param null $description
     * @param null $before_title
     * @param null $after_title
     * @param null $before_widget
     * @param null $after_widget
     */
    public function addSidebar($name, $id, $description = null, $before_title = null, $after_title = null, $before_widget = null, $after_widget = null)
    {
        $sidebar = register_sidebar(array(
            'name' => __($name),
            'id' => $id,
            'description' => __($description),
            'before_title' => $before_title,
            'after_title' => $after_title,
            'before_widget' => $before_widget,
            'after_widget' => $after_widget,
        ));

        $this->sidebars[$id] = $sidebar;
    }

    /**
     * Returns a sidebar.
     *
     * @param $id
     *
     * @return mixed
     */
    public function getSidebar($id)
    {
        return $this->sidebars[$id];
    }

    /**
     * Returns if a sidebar contains a widget.
     *
     * @param $id
     *
     * @return bool
     */
    public function isActiveSidebar($id)
    {
        return is_active_sidebar($id);
    }

    /**
     * Returns the count of sidebars.
     *
     * @return int
     */
    public function getCountSidebars()
    {
        return count($this->sidebars);
    }

    /**
     * Register a navbar area.
     *
     * @return bool
     */
    public function registerNavbarArea($label, $name, $description)
    {
        register_nav_menus(array(
            $label => __($name, $description),
        ));
    }

    /**
     * Checks if a navbar exists.
     *
     * @param $label
     *
     * @return bool
     */
    public function hasNavbar($label)
    {
        return has_nav_menu($label);
    }
}
