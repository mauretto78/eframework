<?php

namespace Framework\Kernel;

/**
 * The Kernel of the framework
 */
class AppKernel extends Kernel
{
    /**
     * @var string $configFile
     */
    private $configFile;

    /**
     * @var string $configFile
     */
    private $environment;

    /**
     * @return string
     */
    public function getConfigFile()
    {
        return $this->configFile;
    }

    /**
     * @param string $configFile
     */
    public function setConfigFile($configFile)
    {
        $this->configFile = $configFile;
    }

    /**
     * @return string
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * @param string $environment
     */
    public function setEnvironment($environment)
    {
        $this->environment = $environment;
    }

    /**
     * Kernel load
     */
    public function load()
    {
        $this->start($this->container, $this->environment);
    }
}
