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
     * Array of loaders.
     *
     * @var array
     */
    private $loaders = array();

    /**
     * Adds a script file to loaders array.
     *
     * @param $handle
     * @param bool $src
     * @param array $deps
     * @param bool $ver
     * @param bool $in_footer
     */
    public function addScript($handle, $src = false, array $deps = array(), $ver = false, $in_footer = false, $admin = false)
    {
        $this->loaders['script'] = array('handle'=>$handle, 'src'=>$src, 'deps'=>$deps, 'ver'=>$ver, 'in_footer'=>$in_footer, 'admin'=>$admin);
    }

    /**
     * Adds a stylesheet file to loaders array.
     *
     * @param $handle
     * @param bool $src
     * @param array $deps
     * @param bool $ver
     * @param bool $in_footer
     */
    public function addStyle($handle, $src = false, array $deps = array(), $ver = false, $in_footer = false, $admin = false)
    {
        $this->loaders['style'] = array('handle'=>$handle, 'src'=>$src, 'deps'=>$deps, 'ver'=>$ver, 'in_footer'=>$in_footer,'admin'=>$admin);
    }

    /**
     * Returns the loaders.
     *
     * @return array
     */
    public function getLoaders()
    {
        return $this->loaders;
    }
}