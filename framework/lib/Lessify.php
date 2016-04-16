<?php

namespace Framework\Framework;

use Framework\App;
use Symfony\Component\Yaml\Yaml;

/**
 * This class is a simple wrapper of lessc class.
 *
 * The class declares a method to merge more less files into a single css output file.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class Lessify
{
    /**
     * @var \lessc
     */
    private $lessc;

    /**
     * @var App
     */
    private $app;

    /**
     * @var bool
     */
    private $comments;

    /**
     * @var string
     */
    private $format;

    /**
     * Lessify constructor.
     *
     * @param \lessc $lessc
     */
    public function __construct(\lessc $lessc)
    {
        $this->lessc = $lessc;
        $config = Yaml::parse(file_get_contents(__DIR__.'/../config/parameters.yml'));
        $this->setComments($config['lessc.comments']);
        $this->setFormat($config['lessc.format']);
    }

    /**
     * Sets the preserve comments flag. [boolean].
     *
     * @param mixed $comments
     */
    public function setComments($comments)
    {
        $this->lessc->setPreserveComments($comments);
        $this->comments = $comments;
    }

    /**
     * Sets the format of output files. [lessjs, compressed, classic].
     *
     * @param string $format
     */
    public function setFormat($format)
    {
        $this->lessc->setFormatter($format);
        $this->format = $format;
    }

    /**
     * Parse a less file into a css output. Array of input less files may be provided.
     *
     * @param mixed  $input
     * @param string $output
     *
     * @throws \Exception
     */
    public function parse($input, $output)
    {
        if (is_array($input)) {
            $outputContent = '';
            foreach ($input as $singleFile) {
                $outputContent .= file_get_contents($singleFile);
                file_put_contents($output, $this->lessc->compile($outputContent), FILE_APPEND);
            }
        } else {
            $this->lessc->compileFile($input, $output);
        }
    }
}
