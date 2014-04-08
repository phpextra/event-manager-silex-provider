<?php

namespace fixtures;

use PHPExtra\EventManager\Silex\Event\PostDispatchEvent;
use PHPExtra\EventManager\Silex\ProxyMapper;
use PHPExtra\EventManager\Silex\ProxyMapperInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\HttpKernel;

/**
 * The ProxyMapperTest class
 *
 * @author Jacek Kobus <kobus.jacek@gmail.com>
 */
class ProxyMapperTest extends \PHPUnit_Framework_TestCase 
{
    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @return ProxyMapperInterface
     */
    public function getProxyMapper()
    {
        return new ProxyMapper();
    }

    public function testRequestEventIsMappedCorrect()
    {
        $sfEvent = \Mockery::mock('Symfony\Component\HttpKernel\Event\GetResponseEvent');
        $event = $this->getProxyMapper()->createProxyEvent($sfEvent);

        $this->assertInstanceOf('\PHPExtra\EventManager\Silex\Event\RequestEvent', $event);
    }

    public function testPreDispatchEventIsMappedCorrect()
    {
        $sfEvent = \Mockery::mock('Symfony\Component\HttpKernel\Event\FilterControllerEvent');
        $event = $this->getProxyMapper()->createProxyEvent($sfEvent);

        $this->assertInstanceOf('\PHPExtra\EventManager\Silex\Event\PreDispatchEvent', $event);
    }

    public function testPostDispatchEventIsMappedCorrect()
    {
        $sfEvent = \Mockery::mock('Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent');
        $event = $this->getProxyMapper()->createProxyEvent($sfEvent);

        $this->assertInstanceOf('\PHPExtra\EventManager\Silex\Event\PostDispatchEvent', $event);
    }

    public function testResponseEventIsMappedCorrect()
    {
        $sfEvent = \Mockery::mock('Symfony\Component\HttpKernel\Event\FilterResponseEvent');
        $event = $this->getProxyMapper()->createProxyEvent($sfEvent);

        $this->assertInstanceOf('\PHPExtra\EventManager\Silex\Event\ResponseEvent', $event);
    }

    public function testPostRequestEventIsMappedCorrect()
    {
        $sfEvent = \Mockery::mock('Symfony\Component\HttpKernel\Event\FinishRequestEvent');
        $event = $this->getProxyMapper()->createProxyEvent($sfEvent);

        $this->assertInstanceOf('\PHPExtra\EventManager\Silex\Event\PostRequestEvent', $event);
    }

    public function testPostResponseEventIsMappedCorrect()
    {
        $sfEvent = \Mockery::mock('Symfony\Component\HttpKernel\Event\PostResponseEvent');
        $event = $this->getProxyMapper()->createProxyEvent($sfEvent);

        $this->assertInstanceOf('\PHPExtra\EventManager\Silex\Event\PostResponseEvent', $event);
    }

    public function testUnknownEventIsMappedCorrect()
    {
        $sfEvent = \Mockery::mock('Symfony\Component\EventDispatcher\Event');
        $event = $this->getProxyMapper()->createProxyEvent($sfEvent);

        $this->assertInstanceOf('\PHPExtra\EventManager\Silex\Event\SilexEvent', $event);
    }

}
 