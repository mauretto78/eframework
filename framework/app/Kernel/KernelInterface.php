<?php

namespace Framework\Kernel;

use DI\Container;

interface KernelInterface
{
    /**
     * Gets the name of the kernel.
     *
     * @return string The kernel name
     */
    public function getName();

    /**
     * Gets the environment.
     *
     * @return string The current environment
     */
    public function getEnvironment();

    /**
     * Gets the services file for of the application.
     *
     * @return string The services file path
     */
    public function getServicesFile();

    /**
     * Gets the application root dir.
     *
     * @return string The application root dir
     */
    public function getRootDir();

    /**
     * Gets the current container.
     *
     * @return Container
     */
    public function getContainer();

    /**
     * Gets the cache directory.
     *
     * @return string The cache directory
     */
    public function getCacheDir();

    /**
     * Gets the log directory.
     *
     * @return string The log directory
     */
    public function getLogDir();

    /**
     * Gets the charset of the application.
     *
     * @return string The charset
     */
    public function getCharset();
}
