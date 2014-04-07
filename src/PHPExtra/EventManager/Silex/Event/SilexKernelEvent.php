<?php

namespace PHPExtra\EventManager\Silex\Event;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\KernelEvent;

class SilexKernelEvent extends SilexEvent
{
    /**
     * @param KernelEvent $event
     * @param string        $name
     */
    function __construct(KernelEvent $event = null, $name = null)
    {
        parent::__construct($event, $name);
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        $event = $this->getSymfonyEvent();
        if($event instanceof KernelEvent){
            return $event->getRequest();
        }
        return null;
    }

    /**
     * @return int
     */
    public function getRequestType()
    {
        $event = $this->getSymfonyEvent();
        if($event instanceof KernelEvent){
            return $event->getRequestType();
        }
        return null;
    }
} 