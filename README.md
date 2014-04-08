#Silex Provider for EventManager

No configuration is needed.

This provider will replace your EventDispatcher class.
Default symfony events were not removed and have higher priority.
It means that PHPExtra event is always running after the sf event.

Below is a reference, to see how events from PHPExtra are mapped onto vanilla sf events.
All events are cancellable (propagationStop property in sf event).
Unlike in symfony, cancellable events are still sent to all listeners. This behaviour may change in
future release of event manager.

## Symfony event mapping

    kernel.request
    PHPExtra\EventManager\Silex\Event\RequestEvent
    Symfony\Component\HttpKernel\Event\GetResponseEvent

    kernel.controller
    PHPExtra\EventManager\Silex\Event\PreDispatchEvent
    Symfony\Component\HttpKernel\Event\FilterControllerEvent

    kernel.view
    PHPExtra\EventManager\Silex\Event\PostDispatchEvent
    Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent

    kernel.response
    PHPExtra\EventManager\Silex\Event\ResponseEvent
    Symfony\Component\HttpKernel\Event\FilterResponseEvent

    kernel.finish_request
    PHPExtra\EventManager\Silex\Event\PostRequestEvent
    Symfony\Component\HttpKernel\Event\FinishRequestEvent

    kernel.terminate
    PHPExtra\EventManager\Silex\Event\PostResponseEvent
    Symfony\Component\HttpKernel\Event\PostResponseEvent

##Installation and usage

If you are using logger, it will be automatically injected into the event manager.
Every class can now be a listener.

    $app = new Silex\Application(array('debug' => true));
    $app->register(new \PHPExtra\EventManager\Silex\EventManagerProvider());

    $em = $app['event_manager'];

    $em->addListener(new \PHPExtra\EventManager\Listener\AnonymousListener(function(RequestEvent $event){
        echo "Im in RequestEvent (Sf GetResponseEvent)";
    }));

    $em->addListener(new \PHPExtra\EventManager\Listener\AnonymousListener(function(SilexKernelEvent $event){
        echo "Im in some Symfony KernelEvent !";
    }));

    $em->addListener($app['my_controller']);

    $em->addListener($app['mailer']);

    ...


