<?php

namespace Framework\Framework\WP;

/**
 * This class wraps WP url functions.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Path
{
    public static function home($blog_id = null, $path = null, $scheme = null)
    {
        return get_home_url($blog_id, $path, $scheme);
    }

    public static function admin($file = null)
    {
        return get_admin_url().$file;
    }

    public static function logIn($redirect = '', $force_reauth = false)
    {
        return wp_login_url($redirect, $force_reauth);
    }

    public static function logOut($redirect)
    {
        return wp_logout_url($redirect);
    }

    public static function template($file = null)
    {
        return get_template_directory_uri().$file;
    }

    public static function child($file = null){
        return get_stylesheet_directory_uri().$file;
    }

    public static function upload($file = null)
    {
        return wp_upload_dir().$file;
    }
}
