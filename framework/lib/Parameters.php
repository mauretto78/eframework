<?php

namespace Framework\Framework;

use Framework\Framework\WP\Admin\Admin;

/**
 * This class gets parameters from Admin options of parameters.php file.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Parameters
{
    /**
     * @var Admin
     */
    private static $admin;

    /**
     * Gets an instance of Admin class.
     *
     * @return Admin
     */
    public static function getAdmin()
    {
        return self::$admin = new Admin();
    }

    /**
     * Gets the param.
     *
     * @param $param
     *
     * @return mixed
     */
    public static function get($param)
    {
        if (self::_existOption($param)) {
            $value = self::getAdmin()->getOption($param);
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
        return self::getAdmin()->hasOption($param);
    }
}
