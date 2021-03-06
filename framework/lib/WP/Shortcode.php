<?php

namespace Framework\Framework\WP;

/**
 * This class creates WP shortcodes.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Shortcode
{
    /**
     * @var string
     */
    private $label;

    /**
     * @var array
     */
    private $arguments = array();

    /**
     * @var mixed
     */
    private $output;

    /**
     * Shortcode constructor.
     *
     * @param $label
     */
    public function __construct($label)
    {
        $this->label = $label;
    }

    /**
     * Sets an argument.
     *
     * @param $arg
     */
    public function setArgument($arg)
    {
        $this->arguments[] = $arg;
    }

    /**
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * @return mixed
     */
    public function getCountArguments()
    {
        return count($this->arguments);
    }

    /**
     * @return mixed
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * @param $output
     */
    public function setOutput($output)
    {
        $this->output = $output;
    }

    /**
     * Calls the add_shortcode function.
     */
    public function create()
    {
        add_filter('the_content', array($this, 'removeTagsFromContent'));
        add_shortcode($this->label, array($this, 'render'));
    }

    /**
     * This is the function called by add_shortcode.
     *
     * @param null $atts
     * @param null $content
     *
     * @return mixed
     */
    public function render($atts = null, $content = null)
    {
        return $this->_handle($this->output, $atts, $content);
    }

    /**
     * Handles the output and renders it in the correct way.
     *
     * @param $output
     * @param array $atts
     * @param null  $content
     *
     * @return mixed
     */
    private function _handle($output, $atts = array(), $content = null)
    {
        if (is_callable($output)) {
            ob_start();
            $render = call_user_func($output, $atts, $content);
            $render .= ob_get_clean();
        } else {
            $render = $output;

            if (!empty($atts)) {
                foreach ($atts as $key => $value) {
                    $render = str_replace('{'.$key.'}', $value, $render);
                }
            }
            if ($content) {
                $render = str_replace('{{content}}', do_shortcode($content), $render);
            }
            $render = preg_replace("/{\w+}/", '', $render);
        }

        return $render;
    }

    /**
     * Removes <p> tag that wraps the shortcode.
     *
     * @param $content
     *
     * @return mixed
     */
    public function removeTagsFromContent($content) {
        $block = implode("|",[$this->label]);
        $rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);
        $rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]",$rep);

        return $rep;
    }
}
