<?php

namespace PHPExtra\EventManager\Silex\Event;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FinishRequestEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * The PostRequestEvent class
 *
 * @author Jacek Kobus <kobus.jacek@gmail.com>
 */
class PostRequestEvent extends SilexKernelEvent
{
    /**
     * @param FinishRequestEvent $event
     */
    function __construct(FinishRequestEvent $event)
    {
        parent::__construct($event);
    }
}