<?php

namespace Framework\Framework\WP\Comments;

/**
 * This class is a decorator for the base Comments.
 *
 * The class renders the comment list with bootstrap style.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class BootstrapComments extends Comments
{
    public function renderElement($comment, $level)
    {
        $output = '';
        $output .= '<div class="comment level-'.$level.'" id="comment-'.$comment->comment_ID.'">';
        $output .= '<div class="comment-author vcard">';
        $output .= get_avatar($comment, 48);
        $output .= sprintf(__('<cite class="fn">%s</cite>'), get_comment_author_link($comment->comment_ID));
        $output .= '<span class="says">says:</span>';
        $output .= '</div>';
        $output .= '<div class="comment-meta commentmetadata">';
        $output .= '<span>'.get_comment_date('', $comment->comment_ID).' '._('at').' '.date('H:i', strtotime($comment->comment_date_gmt)).'</span>';
        $output .= '</div>';
        $output .= '<div class="comment-content">';
        if ($comment->comment_approved) {
            $output .= $comment->comment_content;
        } else {
            $output .= '<em class="comment-awaiting-moderation">'._('Your comment is awaiting moderation.').'</em>';
        }
        $output .= '</div>';
        $output .= '<div class="reply">';
        $output .= get_comment_reply_link(array('depth' => 1, 'max_depth' => $this->max_depth), $comment->comment_ID, $this->post->getId());
        $output .= '</div>';
        $output .= '</div>';

        return $output;
    }
}
