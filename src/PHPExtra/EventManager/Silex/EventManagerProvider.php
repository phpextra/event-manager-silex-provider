<?php

namespace PHPExtra\EventManager\Silex;

use PHPExtra\EventManager\EventManager;
use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * The SilexProvider class
 *
 * @author Jacek Kobus <kobus.jacek@gmail.com>
 */
class EventManagerProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Application $app)
    {
        $app['dispatcher_class'] = 'PHPExtra\\EventManager\\Silex\\CustomEventDispatcher';

        $app['event_manager'] = $app->share(function(Application $app){
            $em = new EventManager();
            if($app->offsetGet('logger') !== null){
                $em->setLogger($app['logger']);
            }
            return $em;
        });

        $app->extend('dispatcher', function(CustomEventDispatcher $dispatcher, Application $app){
            $dispatcher->setEventManager($app['event_manager']);
            return $dispatcher;
        });
    }

    /**
     * {@inheritdoc}
     */
    public function boot(Application $app)
    {
    }
}