<?php

namespace Framework\Framework;

/**
 * This class generates slugs from any type of strings.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Stringify
{
    /**
     * @param $string
     *
     * @return mixed
     */
    public static function clean($string)
    {
        $utf8 = array(
            '/[áàâãªä]/u' => 'a',
            '/[ÁÀÂÃÄ]/u' => 'A',
            '/[ÍÌÎÏ]/u' => 'I',
            '/[íìîï]/u' => 'i',
            '/[éèêë]/u' => 'e',
            '/[ÉÈÊË]/u' => 'E',
            '/[óòôõºö]/u' => 'o',
            '/[ÓÒÔÕÖ]/u' => 'O',
            '/[úùûü]/u' => 'u',
            '/[ÚÙÛÜ]/u' => 'U',
            '/ç/' => 'c',
            '/Ç/' => 'C',
            '/ñ/' => 'n',
            '/Ñ/' => 'N',
            '/–/' => '-', // UTF-8 hyphen to "normal" hyphen
            '/[’‘‹›‚]/u' => ' ', // Literally a single quote
            '/[“”«»„]/u' => ' ', // Double quote
            '/ /' => ' ', // nonbreaking space (equiv. to 0x160)
        );

        return preg_replace(array_keys($utf8), array_values($utf8), $string);
    }

    /**
     * @param $input
     *
     * @return mixed
     */
    public static function toSnake($string)
    {
        $string = self::clean($string);
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $string, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }

        return implode('_', $ret);
    }

    /**
     * @param $string
     *
     * @return mixed
     */
    public static function toCamel($string)
    {
        $string = self::clean($string);

        return str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));
    }

    /**
     * @param $string
     *
     * @return mixed
     */
    public static function fromSnake($string)
    {
        return ucfirst(str_replace('_', ' ', $string));
    }

    /**
     * @param $string
     * @return mixed
     */
    public static function addPlus($string)
    {
        $string = self::clean($string);

        return str_replace(' ', '+', $string);
    }

    /**
     * @param $string
     * @return mixed
     */
    public static function removePlus($string){
        $string = self::clean($string);

        return str_replace('+', ' ', $string);
    }

    /**
     * @param $string
     *
     * @return mixed
     */
    public static function slug($string)
    {
        $string = self::clean($string);
        $string = str_replace(array('[\', \']'), '', $string);
        $string = preg_replace('/\[.*\]/U', '', $string);
        $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
        $string = htmlentities($string, ENT_COMPAT, 'utf-8');
        $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string);
        $string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/'), '-', $string);

        return strtolower(trim($string, '-'));
    }
}
