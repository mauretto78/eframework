<?php

namespace Framework\Framework\WP;

use Framework\Framework\WP\Path;

/**
 * This class creates WP shortcodes.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Upload
{
    /**
     * Uploads a file.
     *
     * @param array $uploadedfile
     * @return mixed
     */
    public static function handle($uploadedfile = array())
    {
        if (!function_exists('wp_handle_upload')) {
            require_once Path::admin('/includes/file.php');
            require_once Path::admin('/includes/image.php');
            require_once Path::admin('/includes/media.php');
        }

        $upload_overrides = array('test_form' => false);
        $movefile = wp_handle_upload($uploadedfile, $upload_overrides);

        if ($movefile && !isset( $movefile['error'])) {
            return $file_url = $movefile['url'];
        }

        return false;
    }
}