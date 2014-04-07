<?php

namespace PHPExtra\EventManager\Silex\Event;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * The SilexEvent class
 *
 * @author Jacek Kobus <kobus.jacek@gmail.com>
 */
class RequestEvent extends SilexEvent
{
    /**
     * @var GetResponseEvent
     */
    protected $symfonyEvent;

    function __construct(GetResponseEvent $event)
    {
        parent::__construct($event);
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->getSymfonyEvent()->getRequest();
    }

    /**
     * @return int
     */
    public function getRequestType()
    {
        return $this->getSymfonyEvent()->getRequestType();
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->getSymfonyEvent()->getResponse();
    }
}