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
     * Query constructor.
     *
     * @param array $args
     * @param bool  $run
     */
    public function __construct($args = array())
    {
        $this->args = $args;
    }

    /**
     * Runs the query.
     *
     * @return array|null|\WP_Post
     */
    public function run()
    {
        return get_posts($this->args);
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
        return count($this->run());
    }

    /**
     * Display pagination links.
     *
     * @return array|string|void
     */
    public function paginate()
    {
        $big = 999999999; // need an unlikely integer

        return paginate_links(array(
            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'format' => '?paged=%#%',
            'current' => max(1, get_query_var('paged')),
            'total' => $this->getCount(),
        ));
    }

    /**
     * Calls wp_reset_query() function.
     */
    public function clear()
    {
        return wp_reset_query();
    }
}
