<?php

namespace Framework\Framework\WP;

/**
 * This class enqueues files in WP.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Enqueuer
{
    /**
     * Array of admin files to enqueue.
     *
     * @var array
     */
    private $adminFiles = array();

    /**
     * Array of front-end files to enqueue.
     *
     * @var array
     */
    private $frontEndFiles = array();

    /**
     * Adds a script file to adminFiles array.
     *
     * @param $handle
     * @param bool  $src
     * @param array $deps
     * @param bool  $ver
     * @param bool  $in_footer
     */
    public function addAdminScript($handle, $src = false, array $deps = array(), $ver = false, $in_footer = false)
    {
        $this->adminFiles[] = array('type' => 'script', 'handle' => $handle, 'src' => $src, 'deps' => $deps, 'ver' => $ver, 'in_footer' => $in_footer);
    }

    /**
     * Adds a stylesheet file to adminFiles array.
     *
     * @param $handle
     * @param bool  $src
     * @param array $deps
     * @param bool  $ver
     * @param bool  $in_footer
     */
    public function addAdminStyle($handle, $src = false, array $deps = array(), $ver = false, $in_footer = false)
    {
        $this->adminFiles[] = array('type' => 'style', 'handle' => $handle, 'src' => $src, 'deps' => $deps, 'ver' => $ver, 'in_footer' => $in_footer);
    }

    /**
     * Adds a script file to frontEndFiles array.
     *
     * @param $handle
     * @param bool  $src
     * @param array $deps
     * @param bool  $ver
     * @param bool  $in_footer
     */
    public function addFrontendScript($handle, $src = false, array $deps = array(), $ver = false, $in_footer = false)
    {
        $this->frontEndFiles[] = array('type' => 'script', 'handle' => $handle, 'src' => $src, 'deps' => $deps, 'ver' => $ver, 'in_footer' => $in_footer);
    }

    /**
     * Adds a stylesheet file to frontEndFiles array.
     *
     * @param $handle
     * @param bool  $src
     * @param array $deps
     * @param bool  $ver
     * @param bool  $in_footer
     */
    public function addFrontendStyle($handle, $src = false, array $deps = array(), $ver = false, $in_footer = false)
    {
        $this->frontEndFiles[] = array('type' => 'style', 'handle' => $handle, 'src' => $src, 'deps' => $deps, 'ver' => $ver, 'in_footer' => $in_footer);
    }

    /**
     * Returns the adminFiles.
     *
     * @return array
     */
    public function getAdminFiles()
    {
        return $this->adminFiles;
    }

    /**
     * Returns the adminFiles.
     *
     * @return array
     */
    public function getFrontEndFiles()
    {
        return $this->frontEndFiles;
    }

    /**
     * Enqueue the loaders.
     */
    public function enqueue()
    {
        $action = Action::getInstance();

        // enqueue admin files
        if (is_admin()) {
            if (!$action->add('admin_enqueue_scripts', array($this, 'hookAdminFiles'))) {
                return false;
            }
        }

        // enqueue front-end files
        if (!is_admin()) {
            if (!$action->add('wp_enqueue_scripts', array($this, 'hookFrontEndFiles'))) {
                return false;
            }
        }

        return true;
    }

    /**
     * Hook all the admin files.
     */
    public function hookAdminFiles()
    {
        foreach ($this->getAdminFiles() as $key => $data) {
            if ($data['type'] == 'script') {
                wp_register_script($data['handle'], $data['src'], $data['deps'], $data['ver'], $data['in_footer']);
                wp_enqueue_script($data['handle']);
            } elseif ($data['type'] == 'style') {
                wp_register_style($data['handle'], $data['src'], $data['deps'], $data['ver'], @$data['media']);
                wp_enqueue_style($data['handle']);
            }
        }
        // tinyMCE
        wp_enqueue_script('tiny_mce');
        if (function_exists('wp_tiny_mce')) {
            wp_tiny_mce();
        }

        // jquery UI sortable
        wp_enqueue_script('jquery-ui-sortable');

        // media
        wp_enqueue_media();
    }

    /**
     * Hook all the front-end files.
     */
    public function hookFrontEndFiles()
    {
        foreach ($this->getFrontEndFiles() as $key => $data) {
            if ($data['type'] == 'script') {
                wp_register_script(@$data['handle'], @$data['src'], @$data['deps'], @$data['ver'], @$data['in_footer']);
                wp_enqueue_script($data['handle']);
            } elseif ($data['type'] == 'style') {
                wp_register_style(@$data['handle'], @$data['src'], @$data['deps'], @$data['ver'], @$data['media']);
                wp_enqueue_style($data['handle']);
            }
        }
    }
}
