<?php

namespace PHPExtra\EventManager\Silex\Event;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;

/**
 * The ControllerEvent class
 *
 * @author Jacek Kobus <kobus.jacek@gmail.com>
 */
class ControllerResultEvent extends SilexKernelEvent
{
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