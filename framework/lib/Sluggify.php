<?php

namespace Framework\Framework;

/**
 * This class contains methods to manipulate strings.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Sluggify
{
    /**
     * Converts a string into a slug.
     *
     * @param $string
     *
     * @return string
     */
    public static function generateSlug($string)
    {
        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);

        return strtolower($slug);
    }

    /**
     * Converts a string into an id.
     *
     * @param $string
     *
     * @return string
     */
    public static function generateId($string)
    {
        $slug = preg_replace('/[^A-Za-z0-9-]+/', '_', $string);

        return strtolower($slug);
    }
}
