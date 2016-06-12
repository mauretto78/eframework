<?php

namespace Framework\Framework\WP\Comments;

/**
 * This interface decorates the Base Comments render.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
interface CommentDecorator
{
    /**
     * Renders the comment list.
     *
     * @param array $args
     *
     * @return mixed
     */
    public function renderList($args = array());
}
