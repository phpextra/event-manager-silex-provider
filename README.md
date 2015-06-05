#EventManager provider for Silex

[![Latest Stable Version](https://poser.pugx.org/phpextra/event-manager/v/stable.svg)](https://packagist.org/packages/phpextra/event-manager-silex-provider)
[![Total Downloads](https://poser.pugx.org/phpextra/event-manager-silex-provider/downloads.svg)](https://packagist.org/packages/phpextra/event-manager-silex-provider)
[![License](https://poser.pugx.org/phpextra/event-manager-silex-provider/license.svg)](https://packagist.org/packages/phpextra/event-manager-silex-provider)
[![Build Status](http://img.shields.io/travis/phpextra/event-manager-silex-provider.svg)](https://travis-ci.org/phpextra/event-manager-silex-provider)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/phpextra/event-manager-silex-provider/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/phpextra/event-manager-silex-provider/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/phpextra/event-manager-silex-provider/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/phpextra/event-manager-silex-provider/?branch=3.0)
[![GitTip](http://img.shields.io/gittip/jkobus.svg)](https://www.gittip.com/jkobus)

No configuration is needed.

This provider will replace your EventDispatcher class.
Default Symfony events were not removed and have higher priority.
It means that PHPExtra event is always running after Symfony event.

All events are cancellable using propagation flag set in symfony event.
Event will be triggered even if propagation will be stopped. 
To see if event was cancelled, use `SilexEvent::isCancelled()` before taking any action.

**Unlike in Symfony, cancellable events are still sent to all listeners**.

##Installation and usage

If you are using logger, it will be automatically injected into the event manager.
Every class can now be a listener.

```php
#bootstrap.php

$app = new Silex\Application(array('debug' => true));
$app->register(new \PHPExtra\EventManager\Silex\EventManagerProvider());


$em = $app['event_manager'];

$em->addListener(new \PHPExtra\EventManager\Listener\AnonymousListener(function(SilexEvent $event){
    echo "Im in some Symfony KernelEvent !";
}));

$em->addListener($app['my_controller']);
$em->addListener($app['mailer']);

# etc ...
```

##Exception handling

Exceptions that will occur during an event are suppressed in production mode and **will not brake the event loop**.
In development, the event manager will break the event loop and throw an exception.

```php
$em->setThrowExceptions(false); // suppress exceptions and continue event loop
```

##Integration with profiler and symfony's Stopwatch component

Stopwatch is enabled when debug mode is on. In production EventManager uses NullStopwatch.

## Symfony event mapping

```
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
```

##Contributing

All code contributions must go through a pull request.
Fork the project, create a feature branch, and send me a pull request.
To ensure a consistent code base, you should make sure the code follows
the [coding standards](http://symfony.com/doc/2.0/contributing/code/standards.html).
If you would like to help take a look at the list of issues.

##Authors

Jacek Kobus - <kobus.jacek@gmail.com>

## License information

See the file LICENSE.txt for copying permission.