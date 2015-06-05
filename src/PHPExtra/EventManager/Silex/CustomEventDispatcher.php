<?php

namespace PHPExtra\EventManager\Silex;

use PHPExtra\EventManager\EventManagerAwareInterface;
use PHPExtra\EventManager\EventManagerInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Triggers symfony events on EventManager using SilexEvent class
 *
 * @author Jacek Kobus <kobus.jacek@gmail.com>
 */
class CustomEventDispatcher extends EventDispatcher implements EventManagerAwareInterface
{
    /**
     * @var EventManagerInterface
     */
    private $em;

    /**
     * {@inheritdoc}
     */
    public function dispatch($eventName, Event $event = null)
    {
        parent::dispatch($eventName, $event);

        if (null === $event) {
            $event = new Event();
        }

        $this->em->trigger(new SilexEvent($eventName, $event));

        return $event;
    }

    /**
     * {@inheritdoc}
     */
    public function setEventManager(EventManagerInterface $em)
    {
        $this->em = $em;

        return $this;
    }
}