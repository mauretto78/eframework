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
     * @return string
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

    /**
     * Gets the Id from an attachment url
     *
     * @param string $attachment_url
     * @return bool|null|string|void
     */
    public static function getAttachmentIdFromUrl($attachment_url = '')
    {

        global $wpdb;
        $attachment_id = false;

        // If there is no url, return.
        if ( '' == $attachment_url )
            return;

        // Get the upload directory paths
        $upload_dir_paths = wp_upload_dir();

        // Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
        if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {

            // If this is the URL of an auto-generated thumbnail, get the URL of the original image
            $attachment_url = preg_replace( '/(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );

            // Remove the upload path base directory from the attachment URL
            $attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );

            // Finally, run a custom database query to get the attachment ID from the modified attachment URL
            $attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );

        }

        return $attachment_id;
    }

    /**
     * Gets the attachment url for a given.
     *
     * @param int $attachment_id
     * @param string $size thumbnail|medium|large
     * @return mixed
     */
    public static function getAttachmentUrlFromId($attachment_id, $size)
    {
        $image = wp_get_attachment_image_src((int)$attachment_id, $size);

        return $image[0];
    }
}
