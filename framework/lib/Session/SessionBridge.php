<?php

namespace Framework\Framework\Session;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Storage\PhpBridgeSessionStorage;

/**
 * This class is a simple bridge for Symfony's HttpFoundation Session class.
 *
 * The class returns Session and Request instances.
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class SessionBridge implements SessionBridgeInterface
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var null|SessionInterface
     */
    protected $session;

    /**
     * SessionBridge constructor.
     */
    public function __construct()
    {
        $request = Request::createFromGlobals();
        $request->setSession(new Session(new PhpBridgeSessionStorage()));
        $session = $request->getSession();

        $this->request = $request;
        $this->session = $session;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function getSession()
    {
        return $this->session;
    }
}
