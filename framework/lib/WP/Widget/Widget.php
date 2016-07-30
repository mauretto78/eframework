<?php

namespace Framework\Framework\WP\Widget;

/**
 * This class creates wordpress widgets sidebars.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Widget
{
    /**
     * Create a widget sidebar area.
     *
     * @param array $args
     *
     * @return mixed
     */
    public static function registerSidebar($args = array())
    {
        return register_sidebar($args);
    }
    
    /**
     * Check if a widget sidebar area is active.
     *
     * @param $name
     *
     * @return mixed
     */
    public static function isActive($name)
    {
        return is_active_sidebar($name);
    }

    /**
     * Display a widget sidebar area.
     *
     * @param $name
     *
     * @return mixed
     */
    public static function get($name)
    {
        return dynamic_sidebar($name);
    }
}
