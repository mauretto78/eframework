<?php

/**
 * This class run WP queries.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
namespace Framework\Framework\WP;

class Query
{
    /**
     * @var array
     */
    private $args = array();

    /**
     * @var \WP_Query
     */
    private $query;

    /**
     * Query constructor.
     *
     * @param array $args
     * @param bool  $run
     */
    public function __construct($args = array())
    {
        if ($args) {
            $this->args = $args;
            $this->query = new \WP_Query($args);
        } else {
            global $wp_query;
            $this->query = $wp_query;
        }
    }

    /**
     * Sets an argument.
     *
     * @param $key
     * @param $value
     */
    public function setArg($key, $value)
    {
        $this->args[$key] = $value;
    }

    /**
     * Gets the count of query.
     *
     * @return int
     */
    public function getCount()
    {
        return $this->query->post_count;
    }

    /**
     * @return int
     */
    public function getMaxNumPages()
    {
        return $this->query->max_num_pages;
    }

    /**
     * @return bool
     */
    public function havePosts()
    {
        return $this->query->have_posts();
    }

    /**
     * Calls the_post() method.
     */
    public function thePost()
    {
        return $this->query->the_post();
    }

    /**
     * Gets post form the query.
     *
     * @return mixed
     */
    public function getPosts()
    {
        return get_posts($this->args);
    }

    /**
     * Display pagination links.
     *
     * @return array|string|void
     */
    public function paginate()
    {
        $big = 999999999; // need an unlikely integer

        $output = '<div class="pagination">';
        $output .= paginate_links(array(
            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'format' => '?paged=%#%',
            'current' => max(1, get_query_var('paged')),
            'total' => $this->getMaxNumPages(),
        ));
        $output .= '</div>';

        return $output;
    }

    /**
     * Calls wp_reset_query() function.
     */
    public function clear()
    {
        return wp_reset_query();
    }
}
