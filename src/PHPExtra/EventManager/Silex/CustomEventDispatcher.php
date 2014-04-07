<?php

namespace PHPExtra\EventManager\Silex;

use PHPExtra\EventManager\EventManager;
use PHPExtra\EventManager\EventManagerAwareInterface;
use PHPExtra\EventManager\EventManagerInterface;
use PHPExtra\EventManager\Silex\Event\ControllerEvent;
use PHPExtra\EventManager\Silex\Event\RequestEvent;
use PHPExtra\EventManager\Silex\Event\SilexEvent;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * The CustomDispatcher class
 *
 * @author Jacek Kobus <kobus.jacek@gmail.com>
 */
class CustomEventDispatcher extends EventDispatcher implements EventManagerAwareInterface
{
    /**
     * @var EventManagerInterface
     */
    protected $eventManager;

    public function dispatch($eventName, Event $event = null)
    {
        if (null === $event) {
            $event = new Event();
        }

        $event->setDispatcher($this);
        $event->setName($eventName);

        if(!$this->hasListeners($eventName)){

        }

        if(($silexEvent = $this->createProxyEvent($eventName, $event)) !== null){
            $this->eventManager->trigger($silexEvent);
        }

        $this->doDispatch($this->getListeners($eventName), $eventName, $event);

        return $event;
    }

    protected function createProxyEvent($name, Event $event)
    {
        $silexEvent = null;
        switch($name){
            case KernelEvents::REQUEST:
                if($event instanceof \Symfony\Component\HttpKernel\Event\GetResponseEvent){
                    $silexEvent = new RequestEvent($event);
                }
                break;
            case KernelEvents::RESPONSE:
            case KernelEvents::CONTROLLER:
                if($event instanceof \Symfony\Component\HttpKernel\Event\FilterControllerEvent){
                    $silexEvent = new ControllerEvent();
                }
                break;
            case KernelEvents::EXCEPTION:
            case KernelEvents::FINISH_REQUEST:
            case KernelEvents::TERMINATE:
            case KernelEvents::VIEW:
            default:
                $silexEvent = new SilexEvent($name);

        }
        var_dump($name, get_class($event));
//        return new SilexEvent();
        return $silexEvent;
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