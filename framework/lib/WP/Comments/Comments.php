<?php

namespace Framework\Framework\WP\Comments;

use Framework\Framework\WP\Post;
use Framework\Framework\WP\Path;
use Framework\Framework\WP\Admin\Admin;

/**
 * This class handles the comments.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Comments implements CommentDecorator
{
    /**
     * @var Post
     */
    protected $post;

    /**
     * @var int
     */
    protected $count;

    /**
     * @var array|int
     */
    protected $list;

    /**
     * Comments constructor.
     *
     * @param Post $post
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
        $args = array('post_id' => $this->post->getId());
        $this->list = get_comments($args);
    }

    /**
     * @return bool
     */
    public function areOpen()
    {
        return comments_open($this->post->getId());
    }

    /**
     * @return bool
     */
    public function arePresent()
    {
        if ($this->count > 0) {
            return true;
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function getCount()
    {
        return $this->count = $this->post->getCommentCount();
    }

    /**
     * @param string|array $args
     *
     * @return array|int
     */
    public function getList($args = '')
    {
        return $this->list = get_comments($args);
    }

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

        $output = '';

        foreach ($this->list as $comment) {
            $output .= '<div class="comment" id="comment-'.$comment->comment_ID.'">';
            $output .= '<p class="comment-author">'.$comment->comment_author._('on').$comment->comment_date.'</p>';
            if ($comment->comment_approved) {
                $output .= '<p class="comment-content">'.$comment->comment_content.'</p>';
            } else {
                $output .= '<em class="comment-awaiting-moderation">'._('Your comment is awaiting moderation.').'</em>';
            }
            $output .= '<p class="reply-comment">'.get_comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $max_depth)), $comment->comment_ID, $this->post->getId()).'</p>';
            $output .= '</div>';
        }

        return $output;
    }

    /**
     * Renders the comment form.
     */
    public function renderForm()
    {
        $args = array(
            'id_form' => 'commentform',
            'class_form' => 'comment-form',
            'id_submit' => 'submit',
            'class_submit' => 'submit',
            'name_submit' => 'submit',
            'title_reply' => __('Leave a Reply'),
            'title_reply_to' => __('Leave a Reply to %s'),
            'cancel_reply_link' => __('Cancel Reply'),
            'label_submit' => __('Post Comment'),
            'format' => 'xhtml',
            'comment_field' => '<p class="comment-form-comment"><label for="comment">'._x('Comment', 'noun').
                '</label><textarea id="comment" class="form-control" name="comment" cols="45" rows="8" aria-required="true">'.
                '</textarea></p>',
            'must_log_in' => '<p class="must-log-in">'.
                sprintf(
                    __('You must be <a href="%s">logged in</a> to post a comment.'),
                    Path::logIn(apply_filters('the_permalink', get_permalink()))
                ).'</p>',
            'logged_in_as' => '<p class="logged-in-as">'.
                sprintf(
                    __('Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>'),
                    Path::admin('profile.php'),
                    $user_identity,
                    Path::logOut(apply_filters('the_permalink', get_permalink()))
                ).'</p>',
            'comment_notes_before' => '<p class="comment-notes">'.
                __('Your email address will not be published.').($req ? $required_text : '').
                '</p>',
            'comment_notes_after' => '<p class="form-allowed-tags">'.
                sprintf(
                    __('You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s'),
                    ' <code>'.allowed_tags().'</code>'
                ).'</p>',
            'fields' => apply_filters('comment_form_default_fields', $fields),
        );

        comment_form($args, $this->post->getId());
    }
}
