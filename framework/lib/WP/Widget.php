<?php

namespace Framework\Framework\WP;

/**
 * This class creates wordpress widgets sidebars.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Widget
{
    /**
     * Create a widget area.
     *
     * @param array $args
     * @return mixed
     */
    public static function registerSidebar($args = array())
    {
        return register_sidebar($args);
    }
}
