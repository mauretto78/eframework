<?php

namespace Framework\Framework;

use Symfony\Component\Yaml\Yaml;

/**
 * This class is a simple class to parse parameters.yml file.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Parameters
{
    public static function get($param)
    {
        $config = Yaml::parse(file_get_contents(__DIR__.'/../config/parameters.yml'));
        return $config[$param];
    }
}