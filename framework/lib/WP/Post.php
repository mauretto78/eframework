<?php

namespace Framework\Framework\WP;

use Framework\Framework\Exceptions\WPException;

/**
 * This class is a wrapper of WP_Post class.
 *
 * It provides methods for easy thumbnail upload and save post.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Post
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var object
     */
    private $author;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $excerpt;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $permalink;

    /**
     * @var int
     */
    private $commentCount;

    /**
     * @var mixed
     */
    private $thumbnail;

    /**
     * @var
     */
    private $type;

    /**
     * @var
     */
    private $cssClass;

    /**
     * @var array
     */
    private $attachments = array();

    /**
     * @var array
     */
    private $meta = array();

    /**
     * @var object WP_Term
     */
    private $cat;

    /**
     * @var object WP_Term
     */
    private $tags;

    /**
     * @var object WP_Term
     */
    private $terms;

    /**
     * @var object WP_Post
     */
    private $object;

    /**
     * Post constructor.
     *
     * @param $id
     */
    public function __construct($id = null)
    {
        if ($id) {
            $this->id = $id;

            try {
                if (!$this->exists()) {
                    //throw exception if post does not exists
                    throw new WPException();
                }
            } catch (WPException $e) {
                echo $e->noFoundPostMessage($id);
            }

            foreach (get_post_meta($this->id) as $key => $value) {
                $this->meta[$key] = $value;
            }
        }
    }

    public function __toString()
    {
        echo $this->getTitle();
    }

    /**
     * Check if a post exists.
     *
     * @return bool
     */
    public function exists()
    {
        if (get_post($this->id)) {
            return true;
        }

        return false;
    }

    /**
     * Automatic update/insert post.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function persist($data = array())
    {
        if ($this->id) {
            $data['ID'] = $this->id;
            $flush = wp_update_post($data);
        } else {
            $_POST['jw_nonce'] = wp_create_nonce('my-jw_nonce');
            $flush = wp_insert_post($data, true);
        }

        return $flush;
    }

    /**
     * Gets the full object of post.
     *
     * @return WP_Post
     */
    public function get()
    {
        return $this->object = get_post($this->id);
    }

    /**
     * Gets the ID of post.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Gets the author of post.
     *
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author = get_userdata($this->get()->post_author);
    }

    public function getAuthorLink()
    {
        return get_author_posts_url($this->get()->post_author);
    }

    /**
     * Gets the publication date of post.
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date = new \DateTime($this->get()->post_date);
    }

    /**
     * @return mixed
     */
    public function getDateForHumans()
    {
        return get_the_date('d F Y', $this->getId());
    }

    /**
     * @return array
     */
    public function getDateForHumansArray()
    {
        $date = array();
        $date['d'] = get_the_date('d', $this->getId());
        $date['m'] = get_the_date('F', $this->getId());
        $date['y'] = get_the_date('Y', $this->getId());

        return $date;
    }

    /**
     * Gets the content of post.
     *
     * @return mixed
     */
    public function getContent()
    {
        $content = $this->get()->post_content;
        $content = apply_filters('the_content', $content);
        $content = str_replace(']]>', ']]&gt;', $content);

        return $this->content = $content;
    }

    /**
     * Gets the title of post.
     *
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title = $this->get()->post_title;
    }

    /**
     * Gets the excerpt of post.
     *
     * @return mixed
     */
    public function getExcerpt()
    {
        return $this->excerpt = get_the_excerpt($this->id);
    }

    /**
     * Gets the status of post.
     *
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status = $this->get()->post_status;
    }

    /**
     * Gets the permalink of post.
     *
     * @return mixed
     */
    public function getPermalink()
    {
        return $this->permalink = $this->get()->guid;
    }

    /**
     * Gets the comment count of post.
     *
     * @return mixed
     */
    public function getCommentCount()
    {
        return $this->commentCount = $this->get()->comment_count;
    }

    /**
     * Uploads and sets the thumbnail of post.
     *
     * @param array $uploadedfile
     */
    public function uploadThumbnail($uploadedfile = array())
    {
        if ($imageUrl = Upload::handle($uploadedfile)) {
            $this->_generateThumbnail($imageUrl, $this->id);
        }
    }

    /**
     * @param $imageUrl
     * @param $postId
     */
    private function _generateThumbnail($imageUrl, $postId)
    {
        $upload_dir = wp_upload_dir();
        $imageData = file_get_contents($imageUrl);
        $filename = basename($imageUrl);

        if (wp_mkdir_p($upload_dir['path'])) {
            $file = $upload_dir['path'].'/'.$filename;
        } else {
            $file = $upload_dir['basedir'].'/'.$filename;
        }
        file_put_contents($file, $imageData);

        $wp_filetype = wp_check_filetype($filename, null);
        $attachment = array(
            'post_mime_type' => $wp_filetype['type'],
            'post_title' => sanitize_file_name($filename),
            'post_content' => '',
            'post_status' => 'inherit',
        );
        $attachId = wp_insert_attachment($attachment, $file, $postId);

        require_once Path::admin('/includes/image.php');

        $attach_data = wp_generate_attachment_metadata($attachId, $file);
        wp_update_attachment_metadata($attachId, $attach_data);
        set_post_thumbnail($postId, $attachId);

        return $this->thumbnail = wp_get_attachment_url($attachId);
    }

    /**
     * Return if the post has a thumbnail.
     *
     * @return bool
     */
    public function hasThumbnail()
    {
        if (has_post_thumbnail($this->id)) {
            return true;
        }

        return false;
    }

    /**
     * Gets the thumbnail Url of post.
     *
     * @return mixed
     */
    public function getThumbnailUrl()
    {
        if (has_post_thumbnail($this->id)) {
            return $this->thumbnail = wp_get_attachment_url(get_post_thumbnail_id($this->id));
        }

        return false;
    }

    /**
     * Renders the thumbnail url of post.
     *
     * If not thumbnail exists, a default image
     *
     * @return mixed
     */
    public function getThumbnail()
    {
        if ($this->getThumbnailUrl() !== false) {
            $url = $this->getThumbnailUrl();
        } else {
            $url = Path::child('/img/no-thumb.jpg');
        }

        return $url;
    }

    /**
     * Gets the status of post.
     *
     * @return mixed
     */
    public function getType()
    {
        return $this->type = $this->get()->post_type;
    }

    /**
     * @return mixed
     */
    public function getCssClass($class)
    {
        return $this->cssClass = implode(' ', get_post_class($class, $this->id));
    }

    /**
     * Returns an array with the IDs of the post attachment.
     *
     * @param string $type
     * @param int $parentId
     *
     * @return array
     */
    public function getAttachments($type, $parentId)
    {
        $args = array(
            'post_parent' => $parentId,
            'post_type' => 'attachment',
            'post_status' => 'any',
            'posts_per_page' => -1,
            'post_mime_type' => $type,
        );

        $query = new Query($args);
        $attachment_ids = array();

        if ($query->havePosts()) {
            while ($query->havePosts()) {
                $query->thePost();
                $attachment_ids[] = get_the_ID();
            }
            $query->clear();
        }

        return $this->attachments = $attachment_ids;
    }

    /**
     * Sets a value for a post meta.
     *
     * @param $key
     * @param $value
     *
     * @return mixed
     */
    public function setMeta($key, $value)
    {
        update_post_meta($this->id, $key, $value);

        return $this->meta[$key] = $value;
    }

    /**
     * Gets a post meta value.
     *
     * @param $key
     *
     * @return mixed
     */
    public function getMeta($key)
    {
        return $this->meta[$key] = get_post_meta($this->id, $key, true);
    }

    /**
     * Gets all post meta data.
     *
     * @return mixed
     */
    public function getAllMeta()
    {
        return $this->meta;
    }

    /**
     * Gets a post meta count.
     *
     * @return int
     */
    public function getMetaCount()
    {
        return count($this->meta);
    }

    /**
     * Gets the category post.
     *
     * @return WP_Term
     */
    public function getCat()
    {
        return $this->cat = get_the_category($this->id);
    }

    public function getCatList($separator = '', $parents = '')
    {
        return get_the_category_list($separator, $parents, $this->id);
    }

    /**
     * Gets the category post count.
     *
     * @return int
     */
    public function getCategoryCount()
    {
        return count(get_the_category($this->id));
    }

    /**
     * Gets the tags for the post.
     *
     * @return WP_Term
     */
    public function getTags()
    {
        return $this->tags = get_the_tags($this->id);
    }

    /**
     * Gets the post tags count.
     *
     * @return int
     */
    public function getTagsCount()
    {
        return count(get_the_tags($this->id));
    }

    /**
     * Gets the post terms.
     *
     * @param $term
     *
     * @return mixed
     */
    public function getTerms($term)
    {
        return $this->terms = wp_get_post_terms($this->id, $term);
    }

    /**
     * Render the post terms.
     *
     * @param $term
     * @param string $style
     * @param string $separator
     *
     * @return string
     */
    public function getTermsList($term, $style = 'span', $separator = '')
    {
        $i = 0;
        $output = '';
        $terms = $this->getTerms($term);
        foreach ($terms as $term) {
            ++$i;
            switch ($style) {
                case 'span':
                    $output .= '<span class="term" id="term-'.$term->term_id.'">'.$term->name.'</span>';
                    break;

                case 'list':
                    $output .= '<li class="term" id="term-'.$term->term_id.'">'.$term->name.'</li>';
                    break;

                case 'slug':
                    $output .= $term->slug.' ';
                    break;

                default:
                    $output .= $term->name.' ';
                    break;
            }

            if ($i < count($terms)) {
                $output .= $separator;
            }
        }

        return $output;
    }

    /**
     * @return array
     */
    public function getPrevLink()
    {
        $prev = get_previous_post();

        $prevLink = array();
        $prevLink['link'] = get_permalink($prev->ID);
        $prevLink['name'] = $prev->post_title;

        return $prevLink;
    }

    /**
     * @return bool
     */
    public function hasPrevLink()
    {
        return (get_previous_post()) ? true : false;
    }

    /**
     * @return array
     */
    public function getNextLink()
    {
        $next = get_next_post();

        $nextLink = array();
        $nextLink['link'] = get_permalink($next->ID);
        $nextLink['name'] = $next->post_title;

        return $nextLink;
    }

    /**
     * @return bool
     */
    public function hasNextLink()
    {
        return (get_next_post()) ? true : false;
    }

    /**
     * Gets the related posts (by tags).
     *
     * @param int $number
     *
     * @return bool|Query
     */
    public function getRelated($number = 4)
    {
        if (!empty($this->getTags())) {
            $tag_ids = array();

            foreach ($this->getTags() as $tag) {
                $tag_ids[] = $tag->term_id;
            }

            $args = array(
                'post_type' => $this->getType(),
                'tag__in' => $tag_ids,
                'post__not_in' => array($this->id),
                'showposts' => $number,
                'ignore_sticky_posts' => 1,
            );

            $query = new Query($args);

            if ($query->getCount() > 0) {
                return $query;
            }

            return false;
        }

        return false;
    }

    /**
     * Gets the first link in the content, for link post format.
     *
     * @return bool
     */
    public function getTheFirstLink()
    {
        if ($this->getFormat() !== 'link') {
            return;
        }

        if (!preg_match('/<a\s[^>]*?href=[\'"](.+?)[\'"]/i', $this->getContent(), $links)) {
            return false;
        }

        return esc_url_raw($links[1]);
    }

    /**
     * Gets the media embedded in the content, for audio and video post format.
     *
     * @param array $type
     *
     * @return mixed
     */
    public function getEmbeddedMedia($types = array())
    {
        $content = apply_filters('the_content', $this->getContent());
        $embed = get_media_embedded_in_content($content, $types);

        if (in_array('audio', $types)):
            $output = str_replace('?visual=true', '?visual=false', $embed[0]); else:
            $output = $embed[0];
        endif;

        return $output;
    }

    /**
     * Gets the chat transcript, for chat post format.
     *
     * @return string
     */
    public function getChatTranscript()
    {
        $chat_output = '';
        $chat_rows = preg_split("/(\r?\n)+|(<br\s*\/?>\s*)+/", $this->getContent());
        $separator = ':';

        foreach ($chat_rows as $chat_row) {
            if (strpos($chat_row, $separator)) {
                $chat_row_split = explode($separator, trim($chat_row), 2);
                $chat_author = strip_tags(trim($chat_row_split[0]));
                $chat_text = trim($chat_row_split[1]);
                $chat_output .= '<div class="chat-row">';
                $chat_output .= '<div class="chat-author '.sanitize_html_class(strtolower("chat-author-{$chat_author}")).' vcard"><cite class="fn">'.$chat_author.'</cite>'.$separator.'</div>';
                $chat_output .= '<div class="chat-text">'.str_replace(array("\r", "\n", "\t"), '', $chat_text).'</div>';
                $chat_output .= '</div><!-- .chat-row -->';
            } else {
                if (!empty($chat_row)) {
                    $chat_output .= '<div class="chat-row">';
                    $chat_output .= '<div class="chat-text">'.str_replace(array("\r", "\n", "\t"), '', $chat_row).'</div>';
                    $chat_output .= '</div><!-- .chat-row -->';
                }
            }
        }

        return $chat_output;
    }

    /**
     * Gets the post format.
     *
     * @return string
     */
    public function getFormat()
    {
        return get_post_format($this->id) ? get_post_format($this->id) : 'standard';
    }

    /**
     * Destroy a post.
     *
     * If $hard is true, delete all the post attachments and postmeta.
     *
     * @param bool $hard
     *
     * @return array|false|\WP_Post
     */
    public function destroy($hard = false)
    {
        if ($hard) {
            // delete all postmeta
            foreach ($this->getAllMeta() as $key => $value) {
                delete_post_meta($this->id, $key, $value);
            }

            // delete all post attachments
            foreach ($this->getAttachments('all', $this->id) as $a) {
                wp_delete_attachment($a->ID, true);
            }
        }

        return wp_delete_post($this->id, true);
    }

    /**
     * Checks if the post is custom.
     *
     * @param null $post
     *
     * @return bool
     */
    public function isCustom()
    {
        $all_custom_post_types = get_post_types(array('_builtin' => false));

        // there are no custom post types
        if (empty($all_custom_post_types)) {
            return false;
        }

        $custom_types = array_keys($all_custom_post_types);
        $current_post_type = get_post_type($this->get());

        // could not detect current type
        if (!$current_post_type) {
            return false;
        }

        return in_array($current_post_type, $custom_types);
    }
}
