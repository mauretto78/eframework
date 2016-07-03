<?php

namespace Framework\Framework\WP;

/**
 * This class wraps WP url functions.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Pag
{
    public static function getTitle()
    {
        return wp_title('', true);
    }

    public static function getMetaTitle()
    {
        global $page, $paged;

        $metaTitle = wp_title('|', true, 'right');
        $metaTitle .= get_bloginfo('name');

        $siteDescription = get_bloginfo('description', 'display');
        if ($siteDescription && ( is_home() || is_front_page() )){
            $metaTitle .= ' | '. $siteDescription;
        }

        if ($paged >= 2 || $page >= 2) {
            $theme = new Theme();
            $metaTitle .= ' | ' . sprintf(__('Page %s', $theme->getFolder(), max($paged, $page)));
        }

        return $metaTitle;
    }

    public static function getMetaDescription()
    {
        return "ciaone";
    }

    public static function getMetaKeywords()
    {
        return "ciaone";
    }
}