<?php

namespace Framework\Framework;

/**
 * This class serialize and unserialize data, and provide support to merge data into array.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Serializer
{
    /**
     * Serialize data.
     *
     * @param $data
     *
     * @return mixed
     */
    public static function serialize($data)
    {
        return serialize($data);
    }

    /**
     * Unserialize data.
     *
     * @param $data
     *
     * @return mixed
     */
    public static function unserialize($data)
    {
        return unserialize($data);
    }

    /**
     * Merges serialized data.
     *
     * @param array $data
     * @param $count
     *
     * @return array
     */
    public static function merge($data = array(), $count)
    {
        $output = array();

        for ($i = 0;$i < $count;++$i) {
            $array = array();
            foreach ($data as $value) {
                $array[] = self::unserialize($value)[$i];
            }
            $output[] = $array;
        }

        return $output;
    }
}
