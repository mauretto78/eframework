<?php

namespace Framework\Framework\WP;

use Framework\Framework\Exceptions\WPException;

/**
 * This class renders breadcrumbs links.
 *
 * This is a modified version of GTBreadcrumbs by Gary Jones.
 *
 * Please refer to https://code.garyjones.co.uk/wordpress-breadcrumbs-class
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Breadcrumbs
{
    /**
     * @var string
     */
    private $wrapperClass;

    /**
     * @var string
     */
    private $rootText;

    /**
     * @var string
     */
    private $tagText;

    /**
     * @var string
     */
    private $categoryText;

    /**
     * @var string
     */
    private $archiveText;

    /**
     * @var string
     */
    private $searchText;

    /**
     * @var string
     */
    private $errorText;

    /**
     * @var string
     */
    private $authorText;

    /**
     * @var string
     */
    private $separator;

    /**
     * @var string
     */
    private $showOnHomepage;

    /**
     * @var \Framework\Framework\Singleton
     */
    private $action;

    /**
     * Breadcrumbs constructor. Set up our options.
     */
    public function __construct()
    {
        /* Set defaults */
        $this->wrapperClass = 'breadcrumbs';
        $this->rootText = 'Home';
        $this->tagText = 'Tag';
        $this->categoryText = 'Category';
        $this->archiveText = 'Archive';
        $this->searchText = 'Search';
        $this->errorText = 'Not Found';
        $this->authorText = 'Author';
        $this->showOnHomepage = false;
        $this->setSeparator('&raquo;');
        $this->action = Action::getInstance();
    }

    /**
     * @param string $wrapperClass
     *
     * @return $this
     */
    public function setWrapperClass($wrapperClass)
    {
        $this->wrapperClass = $wrapperClass;

        return $this;
    }

    /**
     * @param $id
     *
     * @return $this
     */
    public function setSeparator($id)
    {
        $this->separator = ' '.$id.' ';

        return $this;
    }

    /**
     * @param $bool
     *
     * @return $this
     */
    public function setShowOnHomePage($bool)
    {
        $this->showOnHomepage = $bool;

        return $this;
    }

    /**
     * @param $id
     *
     * @return $this
     */
    public function setClassname($id)
    {
        $this->wrapperClass = $id;

        return $this;
    }

    /**
     * @param $id
     *
     * @return $this
     */
    public function setRootText($id)
    {
        $this->rootText = $id;

        return $this;
    }

    /**
     * @param $id
     *
     * @return $this
     */
    public function setTagText($id)
    {
        $this->tagText = $id;

        return $this;
    }

    /**
     * @param $id
     *
     * @return $this
     */
    public function setCategoryText($id)
    {
        $this->categoryText = $id;

        return $this;
    }

    /**
     * @param $id
     *
     * @return $this
     */
    public function setArchiveText($id)
    {
        $this->archiveText = $id;

        return $this;
    }

    /**
     * @param $id
     *
     * @return $this
     */
    public function setSearchText($id)
    {
        $this->searchText = $id;

        return $this;
    }

    /**
     * @param $id
     *
     * @return $this
     */
    public function set404Text($id)
    {
        $this->errorText = $id;

        return $this;
    }

    /**
     * @param $id
     *
     * @return $this
     */
    public function setAuthorText($id)
    {
        $this->authorText = $id;

        return $this;
    }

    /**
     * Output the breadcrumbs by attaching it to the supplied action hook.
     *
     * @param $hook
     * @param int $priority
     *
     * @return $this
     */
    public function hook($hook, $priority = 10)
    {
        try {
            if (!empty($hook)) {
                $this->action->add($hook, array($this, 'render'), $priority);
            } else {
                throw new WPException();
            }
        } catch (WPException $e) {
            echo $e->hookError();
        }

        return $this;
    }

    /**
     * Ensures all crumbs are prefixed by the separator.
     *
     * @param $crumb
     *
     * @return string
     */
    private function _addCrumb($crumb)
    {
        if (strlen($crumb) > 0) {
            return $this->separator.$crumb;
        } else {
            return '';
        }
    }

    /**
     * This does the main work to put the breadcrumbs together.
     *
     * @return string
     */
    public function render()
    {
        global $post;
        $output = '<div class="'.$this->wrapperClass.'">'.$this->rootText;
        if (is_single()) {
            $output .= $this->_addCrumb(' ');
            foreach (get_the_category() as $category) {
                $output .= '<a class="'.$category->cat_ID.'">'.$category->cat_name.'</a>, ';
            }
            $output = substr($output, 0, strlen($output) - 2); /* Strips comma and space from last category */
            $output .= $this->_addCrumb(get_the_title());
        } elseif (is_page()) {
            $ancestors = $this->_getAncestorIds($post->ID, false);
            foreach ($ancestors as $ancestor) {
                if (0 != $ancestor) {
                    $page = new Post($ancestor);
                    $output .= $this->_addCrumb(''.$page->getTitle().'');
                }
            }
            $output .= $this->_addCrumb(get_the_title());
        } elseif (is_tag()) {
            $output .= $this->_addCrumb($this->tagText).$this->_addCrumb(single_tag_title('', false));
        } elseif (is_category()) {
            $output .= $this->_addCrumb($this->categoryText).$this->_addCrumb(single_cat_title('', false));
        } elseif (is_month()) {
            $output .= $this->_addCrumb($this->archiveText).$this->_addCrumb(get_the_time('F Y'));
        } elseif (is_year()) {
            $output .= $this->_addCrumb($this->archiveText).$this->_addCrumb(get_the_time('Y'));
        } elseif (is_author()) {
            $output .= $this->_addCrumb($this->authorText).$this->_addCrumb(get_the_author_meta('display_name', get_query_var('author')));
        } elseif (is_search()) {
            $output .= $this->_addCrumb($this->searchText).$this->_addCrumb(get_search_query());
        } elseif (is_404()) {
            $output .= $this->_addCrumb($this->errorText);
        }
        $output .= '</div>';
        if ((is_home()  || is_front_page()) && !$this->showOnHomepage) {
            /* Wipe output clean */
            $output = '';
        }

        return $output;
    }

    /**
     * get the id of the parent of a given page.
     *
     * @author http://ethancodes.com/2008/09/get-grandparent-pages-in-wordpress/
     *
     * @param int page id
     *
     * @return int the id of the page's parent page
     */
    private function _getParentId($child = 0)
    {
        global $wpdb;
        // Make sure there is a child ID to process
        if ($child > 0) {
            $result = $wpdb->getvar("SELECT postparent FROM $wpdb->posts WHERE ID = $child");
        } else {
            // ... or set a zero result.
          $result = 0;
        }

        return $result;
    }

    /**
     * get an array of ancestor ids for a given page
     * you get an array that looks something like
     * [0] this page id
     * [1] parent page id
     * [2] grandparent page id.
     *
     * @author http://ethancodes.com/2008/09/get-grandparent-pages-in-wordpress/
     *
     * @param int page you want the ancestry of
     * @param bool include this page in the tree (optional, default true)
     * @param bool results top down (optional, default true)
     *
     * @return array
     */
    private function _getAncestorIds($child = 0, $inclusive = true, $topdown = true)
    {
        $ancestors = array();

        if ($child && $inclusive) {
            $ancestors[] = $child;
        }
        while ($parent = $this->_getParentId($child)) {
            $ancestors[] = $parent;
            $child = $parent;
        }
        // If there are ancestors, test for resorting, and apply
        if ($ancestors && $topdown) {
            krsort($ancestors);
        }
        if (!$ancestors) {
            $ancestors[] = 0;
        }

        return $ancestors;
    }
}
