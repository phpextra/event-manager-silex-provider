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

            if($app['debug'] == true){
                $em->setThrowExceptions(true);
            }

            if($app['logger'] !== null){
                $em->setLogger($app['logger']);
            }
            return $em;
        });

        $app['event_manager.proxy_mapper'] = $app->share(function(Application $app){
            return new ProxyMapper();
        });

        $app->extend('dispatcher', function(CustomEventDispatcher $dispatcher, Application $app){
            $dispatcher
                ->setProxyMapper($app['event_manager.proxy_mapper'])
                ->setEventManager($app['event_manager'])
            ;
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