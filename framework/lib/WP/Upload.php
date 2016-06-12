<?php

namespace Framework\Framework\WP;

/**
 * This class handles uploads using wp_handle_upload function.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Upload
{
    /**
     * Uploads a file.
     *
     * @param array $uploadedfile
     *
     * @return mixed
     */
    public static function handle($uploadedFile = array())
    {
        if (!function_exists('wp_handle_upload')) {
            require_once Path::admin('/includes/file.php');
            require_once Path::admin('/includes/image.php');
            require_once Path::admin('/includes/media.php');
        }

        $uploadOverrides = array('test_form' => false);
        $movefile = wp_handle_upload($uploadedFile, $uploadOverrides);

        if ($movefile && !isset($movefile['error'])) {
            return $fileUrl = $movefile['url'];
        }

        return false;
    }
}
