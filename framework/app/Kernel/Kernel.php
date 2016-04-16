<?php

namespace Framework\Kernel;

use DI\ContainerBuilder;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * The abstact class Kernel of the framework.
 */
abstract class Kernel implements KernelInterface
{
    protected $name = 'EFramework';
    protected $environment;
    protected $servicesFile;
    protected $parametersFile;
    protected $container;
    protected $rootDir;
    protected $cacheDir;
    protected $logDir;
    protected $charset;

    const VERSION = '1.0.0';
    const VERSION_ID = 10001;
    const MAJOR_VERSION = 1;
    const MINOR_VERSION = 0;
    const RELEASE_VERSION = 0;
    const EXTRA_VERSION = '';

    const END_OF_MAINTENANCE = '07/2016';
    const END_OF_LIFE = '01/2017';

    public function __construct()
    {
        $this->name = $this->getName();
        $this->environment = $this->getEnvironment();
        $this->servicesFile = $this->getServicesFile();
        $this->parametersFile = $this->getParametersFile();
        $this->container = $this->getContainer();
        $this->rootDir = $this->getRootDir();
        $this->cacheDir = $this->getCacheDir();
        $this->logDir = $this->getLogDir();
    }

    /**
     * Kernel start function.
     */
    public function start($environment)
    {
        $s = new Session();
        $s->start();
        $this->container = $this->initializeContainer($environment);
    }

    /**
     * Gets the container class.
     *
     * @return string The container class
     */
    protected function getContainerClass()
    {
        return ContainerBuilder::class;
    }

    /**
     * Initializes the service container.
     */
    protected function initializeContainer($environment)
    {
        $class = $this->getContainerClass();
        $this->container = new $class();
        $this->container->addDefinitions($this->getParametersFile());
        $this->container->addDefinitions($this->getServicesFile());

        return $this->container->build();
    }
}
