<?php

namespace Framework\Framework\WP;

/**
 * This class provides title and meta tags for wordpress pages.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Seo
{
    /**
     * @var Theme
     */
    private $theme;

    /**
     * @var string
     */
    private $separator;

    /**
     * Seo constructor.
     *
     * @param Theme $theme
     */
    public function __construct(Theme $theme)
    {
        $this->theme = $theme;
        $this->setSeparator('|');

        $action = Action::getInstance();
        $action->add('wp_head', array($this, 'renderMetaDescription'));
    }

    /**
     * @return mixed
     */
    public function getSeparator()
    {
        return $this->separator;
    }

    /**
     * @param mixed $separator
     */
    public function setSeparator($separator)
    {
        $this->separator = $separator;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        if (is_category()) {
            return single_cat_title();
        }

        if (is_author() || is_archive()) {
            return the_archive_title();
        }

        if (is_search()) {
            return 'You searched for: <strong><em>'.esc_html(get_search_query(false)).'</em></strong>';
        }

        return wp_title('', true);
    }

    /**
     * @return string
     */
    public function getMetaTitle()
    {
        global $page, $paged;

        $metaTitle = wp_title($this->getSeparator(), true, 'right');
        $metaTitle .= get_bloginfo('name');

        $siteDescription = get_bloginfo('description', 'display');
        if ($siteDescription && (is_home() || is_front_page())) {
            $metaTitle .= ' '.$this->getSeparator().' '.$siteDescription;
        }

        if ($paged >= 2 || $page >= 2) {
            $metaTitle .= ' '.$this->getSeparator().' '.sprintf(__('Page %s', '_s'), max($paged, $page));
        }

        return $metaTitle;
    }

    /**
     * @return string
     */
    public function getMetaDescription()
    {
        global $post;

        if (!is_single()) {
            return;
        }

        $metaDescription = strip_tags($post->post_excerpt);
        $metaDescription = strip_shortcodes($metaDescription);
        $metaDescription = str_replace(array("\n", "\r", "\t"), ' ', $metaDescription);
        $metaDescription = substr($metaDescription, 0, 125);

        return $metaDescription;
    }

    /**
     * Callback to render the meta description.
     */
    public function renderMetaDescription()
    {
        if ($this->getMetaDescription() != '') {
            echo "<meta name='description' content='".$this->getMetaDescription()."' />";
        }
    }
}
