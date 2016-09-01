<?php

namespace Framework\Framework\WP;

/**
 * This class is a wrapper of WP_Theme class.
 *
 * It provides theme headers, errors, sidebars, navbars and options.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Taxonomy
{
    /**
     * @param $taxonomy
     * @return mixed
     */
    public static function exists($taxonomy)
    {
        return taxonomy_exists($taxonomy);
    }


    public static function getTerms($taxonomy)
    {
        return get_terms($taxonomy);
    }

    /**
     * @param $taxonomy
     * @param string $style
     * @param string $separator
     * @return string
     */
    public static function getTermsList($taxonomy, $style = 'span', $separator = '')
    {
        $i = 0;
        $output = '';
        $terms = self::getTerms($taxonomy);
        foreach ($terms as $term) {
            ++$i;
            switch ($style) {
                case 'span':
                    $output .= '<span class="term" id="term-'.$term->term_id.'">'.$term->name.'</span> ';
                    break;

                case 'list':
                    $output .= '<li class="term" id="term-'.$term->term_id.'">'.$term->name.'</li> ';
                    break;

                case 'button':
                    $output .= '<button id="term-'.$term->term_id.' class="button" data-filter=".'.$term->slug.'">'.$term->name.'</button> ';
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
}
