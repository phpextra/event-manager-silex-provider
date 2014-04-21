<?php

namespace PHPExtra\EventManager\Silex\Event;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

/**
 * The SilexEvent class
 *
 * @author Jacek Kobus <kobus.jacek@gmail.com>
 */
class ResponseEvent extends SilexKernelEvent
{
    /**
     * @param FilterResponseEvent $event
     */
    function __construct(FilterResponseEvent $event)
    {
        parent::__construct($event);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \RuntimeException
     */
    public function getResponse()
    {
        $event = $this->getSymfonyEvent();
        if($event instanceof FilterResponseEvent){
            return $event->getResponse();
        }
        throw new \RuntimeException(sprintf('Unexpected event type: %s (expecting %s)', get_class($event), 'FilterResponseEvent'));
    }
}