<?php

namespace PHPExtra\EventManager\Silex;

use PHPExtra\EventManager\Event\EventInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * The ProxyMapper class
 *
 * @author Jacek Kobus <kobus.jacek@gmail.com>
 */
interface ProxyMapperInterface
{
    /**
     * Create proxy event for given Symfony dispatcher event
     *
     * @param Event $event
     *
     * @return EventInterface
     */
    public function createProxyEvent(Event $event);
}