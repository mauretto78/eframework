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
     * Renders the single comment element.
     *
     * @param Comments $comment
     * @param int      $level
     *
     * @return mixed
     */
    public function renderElement($comment, $level);
}
