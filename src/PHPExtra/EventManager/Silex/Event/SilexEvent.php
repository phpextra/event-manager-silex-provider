<?php

namespace PHPExtra\EventManager\Silex\Event;
use PHPExtra\EventManager\Event\CancellableEventInterface;
use PHPExtra\EventManager\Event\EventInterface;
use Symfony\Component\EventDispatcher\Event as SymfonyEvent;

/**
 * The SilexEvent class
 *
 * @author Jacek Kobus <kobus.jacek@gmail.com>
 */
class SilexEvent implements EventInterface, CancellableEventInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var SymfonyEvent
     */
    protected $symfonyEvent;

    /**
     * @param SymfonyEvent $event
     * @param string $name
     */
    function __construct(SymfonyEvent $event = null, $name = null)
    {
        if($name !== null){
            $this->setName($name);
        }

        if($event !== null){
            $this->setSymfonyEvent($event);
        }
    }

    /**
     * @param SymfonyEvent $symfonyEvent
     *
     * @return $this
     */
    public function setSymfonyEvent($symfonyEvent)
    {
        $this->symfonyEvent = $symfonyEvent;

        return $this;
    }

    /**
     * @return SymfonyEvent
     */
    public function getSymfonyEvent()
    {
        return $this->symfonyEvent;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
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
        $this->getSymfonyEvent()->stopPropagation();
        return $this;
    }
}