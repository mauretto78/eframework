<?php

namespace Framework\Framework\WP\Admin;

/**
 * This class handles admin pages and options in WP panel.
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
     * Admin constructor.
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
     */
    public function setOption($option, $value)
    {
        update_option($option, $value, true);
        $this->options[$option] = $value;
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
        get_option($option);

        return $this->options[$option];
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
}
