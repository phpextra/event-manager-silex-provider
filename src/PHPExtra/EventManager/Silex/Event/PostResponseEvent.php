<?php

namespace PHPExtra\EventManager\Silex\Event;

use Symfony\Component\HttpKernel\Event\PostResponseEvent as SfPostResponseEvent;

/**
 * The PostResponseEvent class
 *
 * @author Jacek Kobus <kobus.jacek@gmail.com>
 */
class PostResponseEvent extends SilexEvent
{
    /**
     * @param SfPostResponseEvent $event
     */
    function __construct(SfPostResponseEvent $event)
    {
        parent::__construct($event);
    }
}