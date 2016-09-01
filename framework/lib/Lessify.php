<?php

namespace Framework\Framework;

use Framework\Framework\WP\Path;

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
     * @var \Less_Parser
     */
    private $parser;

    /**
     * Lessify constructor.
     *
     * @param \lessc $lessc
     */
    public function __construct(\Less_Parser $parser)
    {
        $this->parser = $parser;
        $this->setOption('compress', Parameters::get('lessc.compressed'));
    }

    /**
     * @return \lessc
     */
    public function getParser()
    {
        return $this->parser;
    }

    /**
     * Sets the format of output files. [lessjs, compressed, classic].
     *
     * @param string $format
     */
    public function setOption($option, $value)
    {
        $this->parser->SetOption($option, $value);
    }

    /**
     * @param array $vars
     *
     * @return \Less_Parser
     */
    public function ModifyVars(array $vars)
    {
        return $this->parser->ModifyVars($vars);
    }

    /**
     * @return string
     *
     * @throws \Exception
     */
    public function getCss()
    {
        return $this->parser->getCss();
    }

    public function parse($string)
    {
        return $this->parser->parse($string);
    }

    public function parseFile($input)
    {
        return $this->parser->parseFile($input);
    }

    /**
     * Parse a less file into a css output. Array of input less files may be provided.
     *
     * @param $input
     * @param $output
     *
     * @return \Less_Parser|\Less_Tree_Ruleset
     *
     * @throws \Exception
     */
    public function parseIntoFile($input, $output, $vars = array())
    {
        if (is_array($input)) {
            $fileCount = count($input);
            $i = 0;
            $outputContent = '';
            foreach ($input as $singleFile) {
                ++$i;
                $outputContent .= file_get_contents($singleFile);

                if ($i === $fileCount) {
                    $parsedString = $this->parse($outputContent);
                    if ($vars !== null) {
                        foreach ($vars as $key => $value) {
                            $this->ModifyVars(array(
                                $key => $value,
                            ));
                        }
                    }
                    file_put_contents($output, $parsedString->getCss(), FILE_APPEND);
                }
            }
        } else {
            $parsedFile = $this->parseFile($input);
            if ($vars !== null) {
                foreach ($vars as $key => $value) {
                    $this->ModifyVars(array(
                        $key => $value,
                    ));
                }
            }
            file_put_contents($output, $parsedFile->getCss());
        }
    }

    /**
     * Parse a less file into a css output in caching mode. Array of input less files may be provided.
     *
     * @param $input
     * @param $output
     * @param array $vars
     *
     * @throws \Exception
     */
    public static function parseCached($input, $output, $vars = array())
    {
        $cacheDir = Path::childDir('cache');
        $options = array('cache_dir' => $cacheDir);
        $css_file_name = \Less_Cache::Get($input, $options, $vars);
        $compiled = file_get_contents($cacheDir.'/'.$css_file_name);
        file_put_contents($output, $compiled);
    }
}
