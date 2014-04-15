<?php

namespace PHPExtra\EventManager\Silex\Event;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * The SilexEvent class
 *
 * @author Jacek Kobus <kobus.jacek@gmail.com>
 */
class RequestEvent extends SilexKernelEvent
{
    /**
     * @param GetResponseEvent $event
     * @param string           $name
     */
    function __construct(GetResponseEvent $event = null, $name = null)
    {
        parent::__construct($event, $name);
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        $event = $this->getSymfonyEvent();
        if ($event instanceof GetResponseEvent) {
            return $event->getResponse();
        }

        return null;
    }

    /**
     * Null will be returned only if given sf event is not an instance of GetResponseEvent
     *
     * @return bool|null
     */
    public function hasResponse()
    {
        $event = $this->getSymfonyEvent();
        if ($event instanceof GetResponseEvent) {
            return $event->hasResponse();
        }

        return null;
    }

}