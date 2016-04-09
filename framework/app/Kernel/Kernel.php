<?php

namespace Framework\Kernel;

use DI\ContainerBuilder;

/**
 * The abstact class Kernel of the framework
 */
abstract class Kernel
{
    /**
     * @var ContainerBuilder $container
     */
    public $container;

    /**
     * Kernel constructor.
     * @param ContainerBuilder $container
     */
    public function __construct(ContainerBuilder $container)
    {
        $this->container = $container;
    }

    /**
     * Kernel start function
     */
    public function start($container, $environment)
    {
        $this->container = $this->_loadContainer($container, $environment);
    }

    /**
     * Load the container
     *
     * @param $container
     * @param $environment
     * @return mixed
     */
    private function _loadContainer($container, $environment)
    {
        $container->addDefinitions($this->getConfigFile());
        return $container->build();
    }
}
