<?php

namespace Framework\Framework\Session;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * This class is the interface for SessionBridge class.
 *
 * The class declares methods to get Session and Request instances.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
interface SessionBridgeInterface
{
    /**
     * Returns the Request object.
     *
     * @return Request
     */
    public function getRequest();

    /**
     * Returns the Session object.
     *
     * @return Session
     */
    public function getSession();
}
