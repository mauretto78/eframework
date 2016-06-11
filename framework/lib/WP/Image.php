<?php

namespace Framework\Framework\WP;

/**
 * This class has methods to render uploaded files in WP admin panels.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Image
{
    /**
     * Renders an image or a text link for WP admin panels.
     *
     * @param $path
     */
    public static function renderForAdminPanel($path)
    {
        if (self::check($path)) {
            $output = '<div class="thumbnail" style="background-image: url(\''.$path.'\');"><span title="delete this image" class="thumbnail-delete delete-file"><i class="fa fa-times"></i></span></div>';
        } else {
            $output = '<span class="uploaded-file">'.$path.'</span> <br><a href="#" class="delete-file">Delete this file</a>';
        }

        return $output;
    }

    /**
     * Returns if a file is an image.
     *
     * @param $img
     *
     * @return bool
     */
    public static function check($file)
    {
        if (@is_array(getimagesize($file))) {
            return true;
        }

        return false;
    }
}
