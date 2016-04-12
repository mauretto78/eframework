<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Lessify
    |--------------------------------------------------------------------------
    */
    'lessc.format' => 'compressed',         // [lessjs, compressed, classic]
    'lessc.comments' => true,               // bool
    /*
    |--------------------------------------------------------------------------
    | Sluggify
    |--------------------------------------------------------------------------
    */
    'sluggify.delimiter' => '-',            // string
    'sluggify.limit' => null,               // int
    'sluggify.lowercase' => true,           // bool
    'sluggify.replacements' => array(),     // array()
    'sluggify.transliterate' => true,       // bool
];
