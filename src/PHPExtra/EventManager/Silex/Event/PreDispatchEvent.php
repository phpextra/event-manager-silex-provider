<?php

namespace PHPExtra\EventManager\Silex\Event;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

/**
 * The PreDispatchEvent class
 *
 * @author Jacek Kobus <kobus.jacek@gmail.com>
 */
class PreDispatchEvent extends SilexKernelEvent
{
    /**
     * @return callable
     */
    public function getController()
    {
        $event = $this->getSymfonyEvent();
        if ($event instanceof FilterControllerEvent) {
            return $event->getController();
        }

        return null;
    }
} 