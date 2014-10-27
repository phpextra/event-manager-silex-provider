<?php

namespace fixtures;

use PHPExtra\EventManager\EventManagerInterface;
use PHPExtra\EventManager\Listener\AnonymousListener;
use PHPExtra\EventManager\Silex\Event\SilexEvent;
use PHPExtra\EventManager\Silex\EventManagerServiceProvider;
use Silex\Application;
use Silex\WebTestCase;
use Symfony\Component\HttpKernel\HttpKernel;

/**
 * The EventManagerProviderTest class
 *
 * @author Jacek Kobus <kobus.jacek@gmail.com>
 */
class EventManagerProviderTest extends WebTestCase
{
    /**
     * Creates the application.
     *
     * @return HttpKernel
     */
    public function createApplication()
    {
        $app = new Application(array('debug' => true));
        $app['exception_handler']->disable();
        $app->register(new EventManagerServiceProvider());
        $app->get('/', function(Application $app){
            return 'ok';
        });
        return $app;
    }

    /**
     * @return EventManagerInterface
     */
    public function getEventManager()
    {
        return $this->app['event_manager'];
    }

    public function testRunApplicationWithoutListenersReturnsValidResponse()
    {
        $client = $this->createClient();
        $client->request('GET', '/');

        $this->assertTrue($client->getResponse()->isOk());
        $this->assertEquals('ok', $client->getResponse()->getContent());
    }

    public function testListenersAreTriggeredInCorrectOrder()
    {
        $queue = array();

        $listener = new AnonymousListener(function(SilexEvent $event) use (&$queue){
            $queue[] = get_class($event);
        });

        $this->getEventManager()->addListener($listener);

        $client = $this->createClient();
        $client->request('GET', '/');

        $this->assertEquals('PHPExtra\EventManager\Silex\Event\RequestEvent',       $queue[0]);
        $this->assertEquals('PHPExtra\EventManager\Silex\Event\PreDispatchEvent',   $queue[1]);
        $this->assertEquals('PHPExtra\EventManager\Silex\Event\PostDispatchEvent',  $queue[2]);
        $this->assertEquals('PHPExtra\EventManager\Silex\Event\ResponseEvent',      $queue[3]);
        $this->assertEquals('PHPExtra\EventManager\Silex\Event\PostRequestEvent',   $queue[4]);
        $this->assertEquals('PHPExtra\EventManager\Silex\Event\PostResponseEvent',  $queue[5]);

    }
}
