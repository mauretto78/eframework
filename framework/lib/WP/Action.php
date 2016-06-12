<?php

namespace Framework\Framework\WP;

use Framework\Framework\Singleton;

/**
 * This class manages actions and filters in WP.
 *
 * The class extends the *Singleton* pattern class in order to have only one instance of itself.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Action extends Singleton
{
    /**
     * @var array
     */
    private $actions = array();

    /**
     * @var array
     */
    private $filters = array();

    /**
     * Do a WP action.
     *
     * @param $tag
     * @param string $arg
     */
    public function execute($tag, $arg = '')
    {
        return do_action($tag, $arg);
    }

    /**
     * Adds a WP action.
     *
     * @param $tag
     * @param $callback
     * @param int $priority
     * @param int $accepted_args
     *
     * @return mixed
     */
    public function add($tag, $callback, $priority = 10, $accepted_args = 1)
    {
        $this->actions[$tag] = $callback;

        return add_action($tag, $callback, $priority, $accepted_args);
    }

    public function remove($tag, $callback = null, $priority = 10)
    {
        unset($this->actions[$tag]);

        print_r($callback);

        return remove_action($tag, $callback, $priority);
    }

    /**
     * Adds a WP filter.
     *
     * @param $tag
     * @param $callback
     * @param int $priority
     * @param int $accepted_args
     *
     * @return mixed
     */
    public function filter($tag, $callback, $priority = 10, $accepted_args = 1)
    {
        $this->filters[$tag] = $callback;

        return add_filter($tag, $callback, $priority, $accepted_args);
    }

    /**
     * Returns all the actions.
     *
     * @return array
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     * Returns a specific action function by tag.
     *
     * @param $tag
     *
     * @return mixed
     */
    public function getAction($tag)
    {
        return call_user_func($this->actions[$tag]);
    }

    /**
     * Returns all the filters.
     *
     * @return array
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * Returns a specific filter function by tag.
     *
     * @param $tag
     *
     * @return mixed
     */
    public function getFilter($tag)
    {
        return call_user_func($this->filters[$tag]);
    }
}
