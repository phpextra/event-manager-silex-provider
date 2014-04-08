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
}