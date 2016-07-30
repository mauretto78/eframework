<?php

namespace Framework\Framework\WP;

use Framework\Framework\Exceptions\WPException;

/**
 * This class adds the theme support.
 *
 * Please refer to: https://codex.wordpress.org/Function_Reference/add_theme_support
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Support
{
    /**
     * @var array
     */
    private $features = array();

    /**
     * The allowed features.
     *
     * @var array
     */
    private $allowedFeatures = [
        'post-formats',
        'post-thumbnails',
        'custom-background',
        'custom-header',
        'custom-logo',
        'automatic-feed-links',
        'html5',
        'title-tag',
    ];

    /**
     * Support constructor.
     *
     * @param array $features
     */
    public function __construct($features = array())
    {
        $this->features = $features;
    }

    /**
     * Adds the support for a feature.
     *
     * @param $key
     * @param array $value
     *
     * @return array
     */
    public function add($key, $value = null)
    {
        try {
            if (in_array($key, $this->allowedFeatures)) {
                if ($value) {
                    add_theme_support($key, $value);
                } else {
                    add_theme_support($key);
                }

                return $this->features[$key] = $value;
            } else {
                throw new WPException();
            }
        } catch (WPException $e) {
            echo $e->notAllowedFeature($key);
        }
    }

    /**
     * Checks if a feature exists.
     *
     * @param $feature
     *
     * @return bool
     */
    public function check($feature)
    {
        return current_theme_supports($feature);
    }
}
