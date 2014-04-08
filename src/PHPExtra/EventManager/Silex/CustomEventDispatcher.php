<?php

namespace PHPExtra\EventManager\Silex;

use PHPExtra\EventManager\EventManager;
use PHPExtra\EventManager\EventManagerAwareInterface;
use PHPExtra\EventManager\EventManagerInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * The CustomEventDispatcher class
 *
 * @author Jacek Kobus <kobus.jacek@gmail.com>
 */
class CustomEventDispatcher extends EventDispatcher implements EventManagerAwareInterface
{
    /**
     * @var EventManagerInterface
     */
    protected $eventManager;

    /**
     * @var ProxyMapperInterface
     */
    protected $proxyMapper;

    public function dispatch($eventName, Event $event = null)
    {
        if (null === $event) {
            $event = new Event();
        }

        parent::dispatch($eventName, $event);

        $silexEvent = $this->getProxyMapper()->createProxyEvent($event);

        if($silexEvent){
            $this->eventManager->trigger($silexEvent);
        }

        return $event;
    }

    /**
     * @param ProxyMapperInterface $proxyMapper
     *
     * @return $this
     */
    public function setProxyMapper($proxyMapper)
    {
        $this->proxyMapper = $proxyMapper;

        return $this;
    }

    /**
     * @return ProxyMapperInterface
     */
    public function getProxyMapper()
    {
        return $this->proxyMapper;
    }

    /**
     * {@inheritdoc}
     */
    public function setEventManager(EventManager $manager)
    {
        $this->eventManager = $manager;
        return $this;
    }
}