<?php

namespace Framework\Framework\WP;

/**
 * This class is a wrapper of WP_Theme class.
 *
 * It provides theme headers, errors, sidebars, navbars and options.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Theme
{
    /**
     * @var \WP_Theme
     */
    private $current;

    /**
     * @var array
     */
    private $headers = array();

    /**
     * @var string
     */
    private $folder;

    /**
     * @var string
     */
    private $dir;

    /**
     * @var string
     */
    private $uri;

    /**
     * @var array
     */
    private $errors = array();

    /**
     * @var array
     */
    private $options = array();

    /**
     * @var array
     */
    private $pages = array();

    /**
     * @var array
     */
    private $sidebars = array();

    /**
     * @var array
     */
    private $navbars = array();

    /**
     * Theme constructor.
     *
     * @param null $stylesheet
     * @param null $theme_root
     */
    public function __construct($stylesheet = null, $theme_root = null)
    {
        $this->options = wp_load_alloptions();
        $this->current = wp_get_theme($stylesheet, $theme_root);
        $this->setHeaders();
        $this->setSidebars();
        $this->setNavbars();
    }

    /**
     * Set headers.
     */
    public function setHeaders()
    {
        $this->headers['name'] = $this->current->get('Name');
        $this->headers['uri'] = $this->current->get('ThemeURI');
        $this->headers['description'] = $this->current->get('Description');
        $this->headers['author'] = $this->current->get('Author');
        $this->headers['authorUri'] = $this->current->get('AuthorURI');
        $this->headers['version'] = $this->current->get('Version');
        $this->headers['template'] = $this->current->get('Template');
        $this->headers['status'] = $this->current->get('Status');
        $this->headers['textDomain'] = $this->current->get('TextDomain');
        $this->headers['domainPath'] = $this->current->get('DomainPath');
    }

    /**
     * Get all headers array.
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Get a headers value.
     *
     * @param $key
     *
     * @return bool
     */
    public function get($key)
    {
        if (isset($this->headers[$key])) {
            return $this->headers[$key];
        }

        return false;
    }

    /**
     * @return false|\WP_Theme
     */
    public function getParent()
    {
        return $this->current->parent();
    }

    /**
     * @return bool
     */
    public function hasParent()
    {
        if ($this->getParent() === false) {
            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    public function getFolder()
    {
        return $this->folder = $this->current->get_stylesheet();
    }

    /**
     * @return string
     */
    public function getDir()
    {
        return $this->dir = $this->current->get_stylesheet_directory();
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri = $this->current->get_stylesheet_directory_uri();
    }

    /**
     * @return false|\WP_Error
     */
    public function getErrors()
    {
        return $this->errors = $this->current->errors();
    }

    /**
     * Sets an option.
     *
     * @param $option
     * @param $value
     *
     * @return bool
     */
    public function setOption($option, $value)
    {
        $this->options[$option] = $value;

        return update_option($option, $value, true);
    }

    /**
     * Gets the value of an option.
     *
     * @param $option
     *
     * @return mixed
     */
    public function getOption($option)
    {
        return $this->options[$option];
    }

    /**
     * Checks if exists an option.
     *
     * @param $option
     *
     * @return bool
     */
    public function hasOption($option)
    {
        return (@$this->options[$option]) ? true : false;
    }

    /**
     * Returns all the options.
     *
     * @param $option
     *
     * @return mixed
     */
    public function getAllOptions()
    {
        return $this->options;
    }

    /**
     * Returns the count of options.
     *
     * @param $option
     *
     * @return mixed
     */
    public function getCountOptions()
    {
        return count($this->options);
    }

    /**
     * Adds a page in WP panel.
     *
     * @param AdminPage $page
     *
     * @return AdminPage
     */
    public function addPage(AdminPage $page)
    {
        $this->pages[] = $page;

        return $page;
    }

    /**
     * Returns the count of pages.
     *
     * @return int
     */
    public function getCountPages()
    {
        return count($this->pages);
    }

    /**
     * Sets all the registered sidebars.
     */
    public function setSidebars()
    {
        global $wp_registered_sidebars;

        $sidebars = $wp_registered_sidebars;
        foreach($sidebars as $id => $sidebar) {
            $this->sidebars[$id] = $sidebar;
        }
    }

    /**
     * Register a sidebar.
     *
     * @param $name
     * @param $id
     * @param null $description
     * @param null $before_title
     * @param null $after_title
     * @param null $before_widget
     * @param null $after_widget
     */
    public function addSidebar($name, $id, $description = null, $before_title = null, $after_title = null, $before_widget = null, $after_widget = null)
    {
        $sidebar = register_sidebar(array(
            'name' => __($name),
            'id' => $id,
            'description' => __($description),
            'before_title' => $before_title,
            'after_title' => $after_title,
            'before_widget' => $before_widget,
            'after_widget' => $after_widget,
        ));

        $this->sidebars[$id] = $sidebar;
    }

    /**
     * @return array
     */
    public function getSidebars()
    {
        return $this->sidebars;
    }

    /**
     * Returns a sidebar.
     *
     * @param $id
     *
     * @return mixed
     */
    public function getSidebar($id)
    {
        return $this->sidebars[$id];
    }

    /**
     * Returns if a sidebar contains a widget.
     *
     * @param $id
     *
     * @return bool
     */
    public function isActiveSidebar($id)
    {
        return is_active_sidebar($id);
    }

    /**
     * Returns the count of sidebars.
     *
     * @return int
     */
    public function getCountSidebars()
    {
        return count($this->sidebars);
    }

    /**
     * Sets all the registered navbars.
     */
    public function setNavbars()
    {
        $registered_nav_menus = get_registered_nav_menus();
        foreach($registered_nav_menus as $location => $name) {
            $this->navbars[$location] = array(
                'name' => $name,
                'description' => '',
            );
        }
    }

    /**
     * Register a navbar area.
     *
     * @param $label
     * @param $name
     * @param $description
     *
     * @return array
     */
    public function registerNavbar($label, $name, $description)
    {
        register_nav_menus(array(
            $label => __($name, $description),
        ));

        return $this->navbars[$label] = array(
            'name' => $name,
            'description' => $description,
        );
    }

    /**
     * Unregister a navbar area.
     *
     * @param $label
     */
    public function unregisterNavbar($label)
    {
        unregister_nav_menu($label);

        unset($this->navbars[$label]);
    }

    /**
     * @return array
     */
    public function getNavbars()
    {
        return $this->navbars;
    }

    /**
     * Returns a navbar.
     *
     * @param $label
     *
     * @return mixed
     */
    public function getNavbar($label)
    {
        return $this->navbars[$label];
    }

    /**
     * Checks if a navbar exists.
     *
     * @param $label
     *
     * @return bool
     */
    public function hasNavbar($label)
    {
        return has_nav_menu($label);
    }

    /**
     * Returns the count of navbars.
     *
     * @return int
     */
    public function getCountNavbars()
    {
        return count($this->navbars);
    }

    /**
     * Clear theme cache.
     */
    public function clearCache()
    {
        $this->current->cache_delete();
    }
}
