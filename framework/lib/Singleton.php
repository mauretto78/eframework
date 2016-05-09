<?php

namespace Framework\Framework;

/**
 * This class provides Singleton instance for a class.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Singleton
{
    /**
     * @var null
     */
    private static $instance = null;

    /**
     * Returns the *Singleton* instance of this class.
     *
     * @staticvar Singleton $instance The *Singleton* instances of this class.
     *
     * @return Singleton The *Singleton* instance.
     */
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    /**
     * Destroys the instance of the *Singleton*.
     */
    public static function tearDown()
    {
        self::$instance = null;
    }

    /**
     * Protected constructor to prevent creating a new instance of the
     * *Singleton* via the `new` operator from outside of this class.
     */
    protected function __construct()
    {
    }

    /**
     * Private clone method to prevent cloning of the instance of the
     * *Singleton* instance.
     */
    private function __clone()
    {
    }

    /**
     * Private unserialize method to prevent unserializing of the *Singleton*
     * instance.
     */
    private function __wakeup()
    {
    }
}
