<?php

namespace Framework\Framework\Exceptions;

/**
 * WP Exception class
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class WPException extends \Exception
{
    public function noFoundPostMessage($id) {
        //error message
        $errorMsg = 'Not a valid Post object for id '. $id;

        return $errorMsg;
    }
}