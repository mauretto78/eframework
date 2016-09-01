<?php

namespace Framework\Framework\WP;

use Framework\Framework\Sluggify;

/**
 * This class creates admin pages in WP panel.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class AdminPage
{
    /**
     * Title of the page.
     *
     * @var
     */
    private $title;

    /**
     * Submenu name to be displayed in admin dashboard.
     *
     * @var
     */
    private $menuTitle;

    /**
     * Minimum capability required to view the submenu.
     *
     * @var
     */
    private $capability;

    /**
     * Callback to include a file to render the page.
     *
     * @var
     */
    private $include;

    /**
     * The icon Url of the page.
     *
     * @var
     */
    private $iconUrl;

    /**
     * The position of the page in the admin panel.
     *
     * @var
     */
    private $position;

    /**
     * Parent slug name.
     *
     * @var
     */
    private $parent;

    /**
     * AdminPage constructor.
     *
     * @param $title
     * @param $menuTitle
     * @param $capability
     * @param $include
     * @param null $iconUrl
     * @param null $position
     * @param null $parent
     */
    public function __construct($title, $menuTitle, $capability, $include, $iconUrl = null, $position = null, $parent = null)
    {
        $this->title = $title;
        $this->menuTitle = $menuTitle;
        $this->capability = $capability;
        $this->include = $include;
        $this->iconUrl = ($iconUrl) ? $iconUrl : Path::template('framework/admin/img/icons/ef-icon.png');
        $this->position = $position;
        $this->parent = $parent;

        add_action('admin_menu', array($this, 'init'));
    }

    /**
     * Call the corresponding add_menu_page Wordpress function.
     *
     * @return bool
     */
    public function init()
    {
        if ($this->parent) {
            $addPage = add_submenu_page($this->parent, $this->title, $this->menuTitle, $this->capability, Sluggify::generate($this->title), array($this, 'includeFunction'));
        } else {
            $addPage = add_menu_page($this->title, $this->menuTitle, $this->capability, Sluggify::generate($this->title), array($this, 'includeFunction'), $this->iconUrl, $this->position);
        }

        if (!$addPage) {
            return false;
        }

        return true;
    }

    /**
     * Include the file to render view.
     */
    public function includeFunction()
    {
        include Path::childDir('admin/'.$this->include);
    }
}
