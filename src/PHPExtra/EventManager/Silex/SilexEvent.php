<?php

namespace PHPExtra\EventManager\Silex;

use PHPExtra\EventManager\Event\CancellableEventInterface;
use Symfony\Component\EventDispatcher\Event as SymfonyEvent;

/**
 * The SilexEvent class
 *
 * @author Jacek Kobus <kobus.jacek@gmail.com>
 */
class SilexEvent implements CancellableEventInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var SymfonyEvent
     */
    protected $event;

    /**
     * @param SymfonyEvent $event Symfony event instance
     * @param string       $name Symfony event name
     */
    function __construct($name, SymfonyEvent $event)
    {
        $this->event = $event;
        $this->name = $name;
    }

    /**
     * @return SymfonyEvent
     */
    public function getSymfonyEvent()
    {
        return $this->event;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function isCancelled()
    {
        return $this->getSymfonyEvent()->isPropagationStopped();
    }

    /**
     * {@inheritdoc}
     */
    public function setIsCancelled()
    {
        $this->event->stopPropagation();

        return $this;
    }
}