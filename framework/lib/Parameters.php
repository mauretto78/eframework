<?php

namespace Framework\Framework;

use Framework\Framework\WP\Theme;

/**
 * This class gets parameters from Admin options of parameters.php file.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Parameters
{
    /**
     * @var Theme
     */
    private static $theme;

    /**
     * Gets an instance of Theme class.
     *
     * @return Theme
     */
    public static function getTheme()
    {
        return self::$theme = new Theme();
    }

    /**
     * Gets the param.
     *
     * @param $param
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public static function get($param)
    {
        if (self::_existOption($param)) {
            $value = self::getTheme()->getOption($param);
        } else {
            $config = include __DIR__.'/../config/parameters.php';
            $value = @$config[$param];
        }

        if ($value === null) {
            throw new \Exception('No param was found for the key '.$param);
        }

        return $value;
    }

    /**
     * Checks if a param exists in Admin options.
     *
     * @param $param
     *
     * @return bool
     */
    private static function _existOption($param)
    {
        return self::getTheme()->hasOption($param);
    }
}
