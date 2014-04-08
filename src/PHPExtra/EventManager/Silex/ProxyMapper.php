<?php

namespace PHPExtra\EventManager\Silex;

use PHPExtra\EventManager\Event\EventInterface;
use PHPExtra\EventManager\Silex\Event\PostDispatchEvent;
use PHPExtra\EventManager\Silex\Event\PostRequestEvent;
use PHPExtra\EventManager\Silex\Event\PostResponseEvent;
use PHPExtra\EventManager\Silex\Event\PreDispatchEvent;
use PHPExtra\EventManager\Silex\Event\RequestEvent;
use PHPExtra\EventManager\Silex\Event\ResponseEvent;
use PHPExtra\EventManager\Silex\Event\SilexEvent;
use PHPExtra\EventManager\Silex\Event\SilexKernelEvent;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\FinishRequestEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\HttpKernel\Event\PostResponseEvent as SfPostResponseEvent;

/**
 * The ProxyMapper class
 *
 * @author Jacek Kobus <kobus.jacek@gmail.com>
 */
class ProxyMapper implements ProxyMapperInterface
{
    /**
     * Create proxy event for given Symfony dispatcher event
     *
     * @param Event $event
     * @return EventInterface
     */
    public function createProxyEvent(Event $event)
    {
        if($event instanceof GetResponseForControllerResultEvent){
            $silexEvent = new PostDispatchEvent($event);

        }elseif($event instanceof GetResponseEvent){
            $silexEvent = new RequestEvent($event);

        }elseif($event instanceof FilterControllerEvent){
            $silexEvent = new PreDispatchEvent($event);

        }elseif($event instanceof FilterResponseEvent){
            $silexEvent = new ResponseEvent($event);

        }elseif($event instanceof SfPostResponseEvent){
            $silexEvent = new PostResponseEvent($event);

        }elseif($event instanceof FinishRequestEvent){
            $silexEvent = new PostRequestEvent($event);

        }elseif($event instanceof KernelEvent){
            $silexEvent = new SilexKernelEvent($event);

        }elseif($event instanceof Event){
            $silexEvent = new SilexEvent($event);

        }else{
            $silexEvent = null; // unknown event
        }

        return $silexEvent;
    }
} 