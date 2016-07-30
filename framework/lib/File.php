<?php

namespace Framework\Framework;

/**
 * This class provides the list of available google fonts.
 *
 * This is a modified version of Wordpress-Theme-Customizer-Custom-Controls by paulund https://github.com/digisavvy/Wordpress-Theme-Customizer-Custom-Controls
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class File
{
    /**
     * @param $file
     * @return mixed
     */
    public static function size($file)
    {
        return filesize($file);
    }

    /**
     * @param $bytes
     * @param int $number_format
     * @return string
     */
    public static function formatSizeUnits($bytes, $number_format = 0)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, $number_format) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, $number_format) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, $number_format) . ' kB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }
}