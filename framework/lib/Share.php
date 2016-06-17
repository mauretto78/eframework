<?php

namespace Framework\Framework;

/**
 * This class provides support to sharing links.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Share
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var null|string
     */
    private $title;

    /**
     * @var null|string
     */
    private $text;

    /**
     * @var null|string
     */
    private $source;

    /**
     * @var null|string
     */
    private $image;

    /**
     * @var array
     */
    private $providers = ['facebook', 'twitter', 'google', 'pinterest', 'linkedin'];

    /**
     * Share constructor.
     * @param $url
     * @param null $text
     * @param null $source
     * @param null $image
     */
    public function __construct($url, $title = null, $text = null, $source = null, $image = null)
    {
        $this->url = $url;
        $this->title = $title;
        $this->text = $text;
        $this->source = $source;
        $this->image = $image;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return null|string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param null|string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return null|string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param null|string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return null|string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param null|string $source
     */
    public function setSource($source)
    {
        $this->source = $source;
    }

    /**
     * @return null|string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param null|string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }
    
    /**
     * Facebook share link.
     *
     * @return string
     */
    public function getFacebookLink()
    {
        return 'https://www.facebook.com/sharer/sharer.php?u='.$this->getUrl();
    }

    /**
     * Twitter share link.
     *
     * @return bool|string
     */
    public function getTwitterLink()
    {
        $lenght = strlen($this->getUrl()) + strlen($this->getText()) + 2;
        if($lenght>140) {
            return false;
        }

        return 'https://www.twitter.com/intent/tweet?text='.$this->getText().'&amp;url='.$this->getUrl();
    }

    /**
     * Google share link.
     *
     * @return string
     */
    public function getGoogleLink()
    {
        return 'https://plus.google.com/share?url='.$this->getUrl();
    }

    /**
     * Pinterest share link.
     *
     * @return string
     */
    public function getPinterestLink()
    {
        return 'https://pinterest.com/pin/create/button/?url='.$this->getUrl().'&media='.$this->getImage().'&description='.$this->getText();
    }

    /**
     * Linkedin share link.
     *
     * @return string
     */
    public function getLinkedinLink()
    {
        return 'https://www.linkedin.com/shareArticle?mini=true&url='.$this->getUrl().'&title='.$this->getTitle().'&summary='.$this->getText().'&source='.$this->getSource();
    }

    /**
     * Render the links.
     *
     * @param array $providers
     * @return string
     */
    public function render($providers = array())
    {
        $output = '';

        if(!count($providers)){
            $providers = $this->providers;
        }

        foreach ($providers as $provider){
            $method = 'get'.ucfirst($provider).'Link';
            $output .= '<a class="'.$provider.'" href="'.$this->$method().'">Share with '.ucfirst($provider).'</a>';
        }

        return $output;
    }
}
