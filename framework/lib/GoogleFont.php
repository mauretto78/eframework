<?php

namespace Framework\Framework;

/**
 * This class provides the list of available google fonts.
 *
 * This is a modified version of Wordpress-Theme-Customizer-Custom-Controls by paulund https://github.com/digisavvy/Wordpress-Theme-Customizer-Custom-Controls
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class GoogleFont
{
    private $fonts = array();

    private $fontFile;

    /**
     * GoogleFont constructor.
     */
    public function __construct()
    {
        $this->fontFile = __DIR__.'/../cache/google-web-fonts.txt';
    }

    /**
     * Get the FontFile.
     *
     * @return mixed
     */
    public function getFontFile()
    {
        return $this->fontFile;
    }

    /**
     * Get the google fonts from the API or in the cache.
     *
     * @param int $amount
     *
     * @return mixed
     */
    public function getFonts($amount = 30)
    {
        $apiKey = Parameters::get('google.apikey');

        $cachetime = 86400 * 7;

        if (file_exists($this->fontFile) && $cachetime < filemtime($this->fontFile)) {
            $content = json_decode(file_get_contents($this->fontFile));
        } else {
            $googleApi = 'https://www.googleapis.com/webfonts/v1/webfonts?sort=alpha&key='.$apiKey;
            $response = file_get_contents($googleApi);
            $fp = fopen($this->fontFile, 'w');
            fwrite($fp, $response);
            fclose($fp);
            $content = json_decode($response);
        }

        if ($amount == 'all') {
            return $this->fonts = $content->items;
        } else {
            return $this->fonts = array_slice($content->items, 0, $amount);
        }
    }
}
