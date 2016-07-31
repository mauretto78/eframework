<?php

namespace Framework\Framework\WP\Widget;

/**
 * This class gets widgets sidebars.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Widget
{
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
