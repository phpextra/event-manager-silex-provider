<?php

namespace PHPExtra\EventManager\Silex\Event;

use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;

/**
 * The ControllerResultEvent class
 *
 * @author Jacek Kobus <kobus.jacek@gmail.com>
 */
class PostDispatchEvent extends SilexKernelEvent
{
    /**
     * @param GetResponseForControllerResultEvent $event
     */
    function __construct(GetResponseForControllerResultEvent $event)
    {
        parent::__construct($event);
    }

    /**
     * @return callable
     */
    public function getControllerResult()
    {
        $event = $this->getSymfonyEvent();
        if($event instanceof GetResponseForControllerResultEvent){
            return $event->getControllerResult();
        }
        return null;
    }

    /**
     * @param $result
     * @return $this
     */
    public function setControllerResult($result)
    {
        $event = $this->getSymfonyEvent();
        if($event instanceof GetResponseForControllerResultEvent){
            $event->setControllerResult($result);
        }
        return $this;
    }
} 