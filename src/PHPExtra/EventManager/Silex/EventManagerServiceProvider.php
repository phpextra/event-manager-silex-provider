<?php

namespace PHPExtra\EventManager\Silex;

use Psr\Log\NullLogger;
use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\Stopwatch\Stopwatch;

/**
 * The SilexProvider class
 *
 * @author Jacek Kobus <kobus.jacek@gmail.com>
 */
class EventManagerServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Application $app)
    {
        $app['dispatcher_class'] = 'PHPExtra\\EventManager\\Silex\\CustomEventDispatcher';

        $app['event_manager'] = $app->share(function (Application $app) {

            $em = new ProfilableEventManager();

            if ($app['logger'] !== null) {
                $em->setLogger($app['logger']);
            }else{
                $em->setLogger(new NullLogger());
            }

            if($app['debug']){
                $em
                    ->setStopwatch($app['stopwatch'])
                    ->setThrowExceptions($app['debug'])
                ;
            }else{
                $em->setStopwatch(new NullStopwatch());
            }

            return $em;
        });

        $app['event_manager.proxy_mapper'] = $app->share(function (Application $app) {
            return new ProxyMapper();
        });

        $app->extend('dispatcher', function (CustomEventDispatcher $dispatcher, Application $app) {
            $dispatcher
                ->setProxyMapper($app['event_manager.proxy_mapper'])
                ->setEventManager($app['event_manager'])
            ;

            return $dispatcher;
        });

        $app['stopwatch'] = $app->share(function () {
            return new Stopwatch();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function boot(Application $app)
    {
    }
}