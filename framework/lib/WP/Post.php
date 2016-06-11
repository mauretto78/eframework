<?php

namespace Framework\Framework\WP;

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
     * @var int
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
     * @var object WP_Post
     */
    private $object;

    /**
     * Post constructor.
     * @param $id
     */
    public function __construct($id = null)
    {
        if($id){
            $this->id = $id;

            foreach (get_post_meta($this->id) as $key => $value) {
                $this->meta[$key] = $value;
            }

            $this->getCat();
            $this->getTags();
        }
    }

    /**
     * Automatic update/insert post.
     *
     * @param array $data
     * @return mixed
     */
    public function persist($data = array())
    {
        if($this->id){
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
     * Gets the author of post.
     *
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author = $this->get()->post_author;
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
        return $this->excerpt = $this->get()->post_excerpt;
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
        if($imageUrl = Upload::handle($uploadedfile)){
            $this->_generateThumbnail($imageUrl, $this->id);
        }
    }

    /**
     * @param $imageUrl
     * @param $postId
     */
    private function _generateThumbnail($imageUrl, $postId){
        $upload_dir = wp_upload_dir();
        $imageData = file_get_contents($imageUrl);
        $filename = basename($imageUrl);

        if(wp_mkdir_p($upload_dir['path'])){
            $file = $upload_dir['path'] . '/' . $filename;
        } else {
            $file = $upload_dir['basedir'] . '/' . $filename;
        }
        file_put_contents($file, $imageData);

        $wp_filetype = wp_check_filetype($filename, null );
        $attachment = array(
            'post_mime_type' => $wp_filetype['type'],
            'post_title' => sanitize_file_name($filename),
            'post_content' => '',
            'post_status' => 'inherit'
        );
        $attachId = wp_insert_attachment( $attachment, $file, $postId );

        require_once Path::admin('/includes/image.php');
        
        $attach_data = wp_generate_attachment_metadata( $attachId, $file );
        wp_update_attachment_metadata( $attachId, $attach_data );
        set_post_thumbnail( $postId, $attachId );

        return $this->thumbnail = wp_get_attachment_url($attachId);
    }

    /**
     * Gets the thumbnail Url of post.
     *
     * @return mixed
     */
    public function getThumbnail()
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
    public function getThumbnailUrl()
    {
        if ($this->getThumbnail() !== false) {
            $url = $this->getThumbnail();
        } else {
            $url = Path::template('/img/default.jpg');
        }

        return $url;
    }

    /**
     * Sets a value for a post meta.
     *
     * @param $key
     * @param $value
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

    /**
     * Gets the category post count.
     *
     * @return int
     */
    public function getCategoryCount()
    {
        return count($this->cat);
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
        return count($this->tags);
    }
}



