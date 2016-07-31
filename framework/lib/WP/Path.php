<?php

namespace Framework\Framework\WP;

/**
 * This class wraps WP url functions.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Path
{
    /**
     * @param null $blog_id
     * @param null $path
     * @param null $scheme
     *
     * @return mixed
     */
    public static function home($blog_id = null, $path = null, $scheme = null)
    {
        return get_home_url($blog_id, $path, $scheme);
    }

    /**
     * @return mixed
     */
    public static function homeDir()
    {
        if (!function_exists('get_home_path')) {
            require_once ABSPATH.'/wp-admin/includes/file.php';
        }

        return get_home_path();
    }

    /**
     * @return mixed
     */
    public static function currentDir()
    {
        return dirname(__DIR__);
    }

    /**
     * @return mixed
     */
    public static function contentUrl()
    {
        return content_url();
    }

    /**
     * @param null $file
     *
     * @return string
     */
    public static function contentDir($file = null)
    {
        return self::homeDir().'wp-content/'.self::_clean($file);
    }

    /**
     * @param null $file
     *
     * @return string
     */
    public static function admin($file = null)
    {
        return get_admin_url().'/'.self::_clean($file);
    }

    /**
     * @param string $redirect
     * @param bool   $force_reauth
     *
     * @return mixed
     */
    public static function logIn($redirect = '', $force_reauth = false)
    {
        return wp_login_url($redirect, $force_reauth);
    }

    /**
     * @param $redirect
     *
     * @return mixed
     */
    public static function logOut($redirect)
    {
        return wp_logout_url($redirect);
    }

    /**
     * @param null $file
     *
     * @return string
     */
    public static function template($file = null)
    {
        return get_template_directory_uri().'/'.self::_clean($file);
    }

    /**
     * @param null $file
     *
     * @return string
     */
    public static function templateDir($file = null)
    {
        return get_template_directory().'/'.self::_clean($file);
    }

    /**
     * @param null $file
     *
     * @return string
     */
    public static function child($file = null)
    {
        return get_stylesheet_directory_uri().'/'.self::_clean($file);
    }

    /**
     * @param null $file
     *
     * @return string
     */
    public static function childDir($file = null)
    {
        return get_stylesheet_directory().'/'.self::_clean($file);
    }

    /**
     * @param null $file
     *
     * @return string
     */
    public static function upload($file = null)
    {
        return wp_upload_dir().'/'.self::_clean($file);
    }

    /**
     * Clean up a file path before appending it.
     *
     * @param $file
     *
     * @return mixed
     */
    private static function _clean($file)
    {
        return str_replace(
            array(
                self::homeDir(),
                self::home(),
                '/wp-admin/',
                '/wp-content/',
                '/wp-includes/',
            ),
            '',
            $file);
    }
}
