<?php

namespace Framework\Framework\WP;

/**
 * This class is a wrapper of WP_Theme class.
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
     * Theme constructor.
     *
     * @param null $stylesheet
     * @param null $theme_root
     */
    public function __construct($stylesheet = null, $theme_root = null)
    {
        $this->current = wp_get_theme( $stylesheet, $theme_root);
        $this->setHeaders();
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
     * @return bool
     */
    public function get($key)
    {
        if(isset($this->headers[$key])){
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
        if($this->getParent() === false){
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
     * Clear theme cache.
     */
    public function clearCache()
    {
        $this->current->cache_delete();
    }
}
