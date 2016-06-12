<?php

namespace Framework\Framework\Exceptions;

/**
 * WPException class.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class WPException extends \Exception
{
    public function noFoundPostMessage($id)
    {
        //error message
        $errorMsg = 'Not a valid Post object for id '.$id;

        return $errorMsg;
    }

    public function notAllowedFeature($feature)
    {
        //error message
        $errorMsg = $feature.' is not a valid feature ';

        return $errorMsg;
    }

    public function hookError()
    {
        //error message
        $errorMsg = ' The "hook" method must contain the name of an action hook. e.g. $breadcrumbs->hook(\'hooknamehere\' ';

        return $errorMsg;
    }
}
