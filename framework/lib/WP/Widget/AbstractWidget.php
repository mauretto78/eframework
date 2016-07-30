<?php

namespace Framework\Framework\WP\Widget;

use Framework\Framework\WP\Path;
use Framework\Framework\WP\Enqueuer;
use Framework\Framework\Stringify;

/**
 * Abstract WP_Widget Class wrapper.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
abstract class AbstractWidget extends \WP_Widget
{
    /**
     * @var string
     */
    protected $widgetName;

    /**
     * @var string
     */
    protected $widgetDescription;

    /**
     * AbstractWidget constructor.
     *
     * @param string $widgetName
     * @param string $widgetDesc
     */
    public function __construct($widgetName, $widgetDesc)
    {
        $this->setWidgetName($widgetName);
        $this->setWidgetDescription($widgetDesc);
        $this->enqueueStyle();

        parent::WP_Widget(false, __($this->getWidgetName(), $this->getWidgetLabel()), array('description' => __($this->getWidgetDescription(), $this->getWidgetLabel())));
    }

    /**
     * @return string
     */
    public function getWidgetName()
    {
        return $this->widgetName;
    }

    /**
     * @param string $widgetName
     */
    public function setWidgetName($widgetName)
    {
        $this->widgetName = $widgetName;
    }

    /**
     * @return string
     */
    public function getWidgetLabel()
    {
        return get_class($this);
    }

    /**
     * @return string
     */
    public function getWidgetDescription()
    {
        return $this->widgetDescription;
    }

    /**
     * @param string $widgetDescription
     */
    public function setWidgetDescription($widgetDescription)
    {
        $this->widgetDescription = $widgetDescription;
    }

    /**
     * Enqueues the main css file for the plugin.
     */
    public function enqueueStyle()
    {
        $scLabel = Stringify::toSnake($this->getWidgetLabel());

        $e = new Enqueuer();
        $e->addFrontendStyle($scLabel.'-style', Path::child('/widgets/'.$scLabel.'/css/widget.css'), array());
        $e->enqueue();
    }
}
