<?php

namespace Framework\Framework\WP\PostType;

use Framework\Framework\WP\Action;
use Framework\Framework\WP\Path;

/**
 * This class creates new custom post types.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class PostType
{
    /**
     * The name of the post type.
     *
     * @var string
     */
    public $name;

    /**
     * A list of user-specific options for the post type.
     *
     * @var array
     */
    public $args = array();

    /**
     * @var \Framework\Framework\Singleton
     */
    public $action;

    /**
     * @var array
     */
    public $columns = array();

    /**
     * Sets default values, registers the passed post type, and
     * listens for when the post is saved.
     *
     * @param string $name The name of the desired post type.
     */
    public function __construct($name)
    {
        $this->name = strtolower($name);
        $this->action = Action::getInstance();
        $this->register();
    }

    /**
     * Sets an attribute.
     *
     * @param $key
     * @param $value
     */
    public function setAttribute($key, $value)
    {
        $this->args[$key] = $value;
    }

    /**
     * Adds a metabox.
     *
     * @param MetaBox $metabox
     */
    public function addMetaBox(MetaBox $metabox)
    {
        return $metabox->createBoxFor($this->name);
    }

    /**
     * Registers a new taxonomy, associated with the instantiated post type.
     *
     * @param string $taxonomyName The name of the desired taxonomy
     * @param string $plural       The plural form of the taxonomy name. (Optional)
     * @param array  $options      A list of overrides
     */
    public function addTaxonomy($taxonomyName, $plural = '', $options = array(), $sharedPostTypeArray = null)
    {
        // Create local reference so we can pass it to the init cb.
        $post_type_name = $this->name;

        // If no plural form of the taxonomy was provided, do a crappy fix. :)

        if (empty($plural)) {
            $plural = $taxonomyName.'s';
        }

        // Taxonomies need to be lowercase, but displaying them will look better this way...
        $taxonomyName = ucwords($taxonomyName);

        // At WordPress' init, register the taxonomy
        $this->action->add('init',
            function () use ($taxonomyName, $plural, $post_type_name, $options, $sharedPostTypeArray) {
                // Override defaults with user provided options

                $options = array_merge(
                    array(
                        'hierarchical' => false,
                        'label' => $taxonomyName,
                        'singular_label' => $plural,
                        'show_ui' => true,
                        'query_var' => true,
                        'rewrite' => array('slug' => strtolower($taxonomyName)),
                    ), $options
                );

                // name of taxonomy, associated post type, options
                if (is_array($sharedPostTypeArray)) {
                    register_taxonomy(strtolower($taxonomyName), $sharedPostTypeArray, $options);
                } else {
                    register_taxonomy(strtolower($taxonomyName), $post_type_name, $options);
                }
            });
    }

    /**
     * Calls registerPostType function.
     *
     * @return bool
     */
    public function register()
    {
        if (!$this->action->add('init', array($this, 'registerPostType'))) {
            return false;
        }

        return true;
    }

    /**
     * Registers the post type.
     */
    public function registerPostType()
    {
        $n = ucwords($this->name);
        $n = str_replace('_', ' ', $n);

        $labels = array(
            'name' => _x($n, 'Post Type General Name', 'eframework'),
            'singular_name' => _x($n, 'Post Type Singular Name', 'eframework'),
            'menu_name' => __($n, 'eframework'),
            'parent_item_colon' => __('Parent '.$n, 'eframework'),
            'all_items' => __('All '.$n, 'eframework'),
            'view_item' => __('View '.$n, 'eframework'),
            'add_new_item' => __('Add New '.$n, 'eframework'),
            'add_new' => __('Add '.$n, 'eframework'),
            'edit_item' => __('Edit '.$n, 'eframework'),
            'update_item' => __('Update '.$n, 'eframework'),
            'search_items' => __('Search '.$n, 'eframework'),
            'not_found' => __('Not Found', 'eframework'),
            'not_found_in_trash' => __('Not found in Trash', 'eframework'),
        );

        $args = array(
            'label' => $n,
            'singular_name' => $n,
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'query_var' => true,
            'menu_icon' => Path::template('/img/widget.png'),
            'rewrite' => true,
            'capability_type' => 'post',
            'hierarchical' => false,
            'menu_position' => null,
            'supports' => array('title', 'editor', 'thumbnail'),
            'has_archive' => true,
        );

        // Take user provided options, and override the defaults.
        $args = array_merge($args, $this->args);

        register_post_type($this->name, $args);
    }

    /**
     * Sets a column.
     *
     * @param $key
     * @param $value
     */
    public function setColumn($key, $value)
    {
        $this->columns[$key] = $value;
    }

    /**
     * Gets a column.
     *
     * @param $key
     *
     * @return mixed
     */
    public function getColumn($key)
    {
        return $this->columns[$key];
    }

    /**
     * Returns the column count.
     * 
     * @return mixed
     */
    public function getColumnsCount()
    {
        return count($this->columns);
    }

    /**
     * Sets the column to display in post list.
     *
     * @param array $cols
     */
    public function setColumns($cols = array())
    {
        $this->action->filter('manage_edit-'.$this->name.'_columns', function ($columns) use ($cols) {
            $columns[$this->name.'_thumbnail'] = 'Thumbnail';
            foreach ($cols as $key => $value) {
                $columns[$this->name.'_'.$key] = $key;
            }

            return $columns;
        });

        // set $this->columns
        $this->setColumn($this->name.'_thumbnail', 'Thumbnail');
        foreach ($cols as $key => $value) {
            $this->setColumn($this->name.'_'.$key, $value);
        }

        $this->_setColumnsContent();
    }

    /**
     * Sets the column content from $this->columns array.
     */
    private function _setColumnsContent()
    {
        add_image_size('admin-list-thumb', 100, 100, false);

        $this->action->add('manage_posts_custom_column', function ($name) {
            global $post;

            if ($name == $this->name.'_thumbnail') {
                if (has_post_thumbnail($post->ID)) {
                    echo the_post_thumbnail('admin-list-thumb');
                } else {
                    echo 'no image uploaded.';
                }
            }

            foreach ($this->columns as $key => $value) {
                if ($name == $key) {
                    if (is_array($value)) {
                        call_user_func($value['callback']);
                    } else {
                        $views = get_post_meta($post->ID, $value, true);
                        echo $views;
                    }
                }
            }
        });
    }
}
