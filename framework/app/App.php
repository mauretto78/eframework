<?php

namespace Framework;

use Framework\Kernel\Kernel;

/**
 * The Kernel of the framework.
 */
class App extends Kernel
{
    /**
     * App constructor.
     *
     * Sets the environment and the config files.
     *
     * @param $environment
     */
    public function __construct($environment = 'dev')
    {
        $this->setEnvironment($environment);
        $this->setParametersFile($this->getRootDir().'/../config/parameters.php');
        $this->setServicesFile($this->getRootDir().'/../config/services.php');

        $this->run();
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getEnvironment()
    {
        return $this->environment;
    }

    public function setEnvironment($environment)
    {
        $this->environment = $environment;
    }

    public function getServicesFile()
    {
        return $this->servicesFile;
    }

    public function setServicesFile($servicesFile)
    {
        $this->servicesFile = $servicesFile;
    }

    public function getParametersFile()
    {
        return $this->parametersFile;
    }

    public function setParametersFile($parametersFile)
    {
        $this->parametersFile = $parametersFile;
    }

    public function getContainer()
    {
        return $this->container;
    }

    public function getRootDir()
    {
        return $this->rootDir = __DIR__;
    }

    public function getCacheDir()
    {
        return $this->cacheDir = dirname(__DIR__).'/cache/'.$this->getEnvironment();
    }

    public function getLogDir()
    {
        return $this->logDir = dirname(__DIR__).'/logs';
    }

    public function getCharset()
    {
        return 'UTF-8';
    }

    /**
     * Starts the App.
     */
    private function run()
    {
        $this->start($this->environment);
    }
}
