<?php

namespace Framework\Framework\WP\Comments;

use Framework\Framework\WP\Admin\Admin;

/**
 * This class is a decorator for the base Comments.
 *
 * The class renders the comment list with bootstrap style.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class BootstrapComments extends Comments implements CommentDecorator
{
    /**
     * Renders the comment list.
     *
     * @param array $args
     *
     * @return mixed
     */
    public function renderList($args = array())
    {
        extract($args, EXTR_SKIP);

        if (!isset($args['depth'])) {
            $depth = 1;
        }

        if (!isset($args['max_depth'])) {
            $admin = new Admin();
            $max_depth = $admin->getOption('thread_comments_depth');
        }

        $d = 'l, F jS, Y';

        $output = '';
        foreach ($this->list as $comment) {
            $output .= '<div class="row comment" id="comment-'.$comment->comment_ID.'">';
            $output .= '<div class="col-sm-2 col-xs-4">';
            $output .= '<div class="comment-avatar">';
            $output .= get_avatar($comment, 70);
            $output .= '</div>';
            $output .= '<div class="comment-meta">';
            $output .= '<span>'.printf(__('<cite class="fn">%s</cite>'), get_comment_author_link($comment->comment_ID)).'</span>';
            $output .= '<span><strong>'.get_comment_date($d, $comment->comment_ID).' '._('at').' '.date('H:i', strtotime($comment->comment_date_gmt)).'</strong></span>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '<div class="col-sm-10 col-xs-8">';
            $output .= '<div class="comment-text">';
            if ($comment->comment_approved) {
                $output .= $comment->comment_content;
            } else {
                $output .= '<em class="comment-awaiting-moderation">'._('Your comment is awaiting moderation.').'</em>';
            }
            $output .= '<p class="reply-comment">'.get_comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $max_depth)), $comment->comment_ID, $this->post->getId()).'</p>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';
        }

        return $output;
    }
}
