<?php

/**
 * Copyright (c) 2014 Jacek Kobus <kobus.jacek@gmail.com>
 * See the file LICENSE.txt for copying permission.
 */
 
namespace PHPExtra\EventManager\Silex;

use PHPExtra\EventManager\Event\EventInterface;
use PHPExtra\EventManager\EventManager;
use PHPExtra\EventManager\EventManagerInterface;
use PHPExtra\EventManager\Worker\WorkerInterface;
use Symfony\Component\Stopwatch\Stopwatch;

/**
 * Adds Symfony Stopwatch
 *
 * @author Jacek Kobus <kobus.jacek@gmail.com>
 */
class ProfilableEventManager extends EventManager implements EventManagerInterface
{
    /**
     * @var Stopwatch
     */
    private $stopwatch;

    /**
     * {@inheritdoc}
     */
    public function trigger(EventInterface $event)
    {
        $eventName = get_class($event);
        $this->stopwatch->start($eventName);
        $result = parent::trigger($event);
        $this->stopwatch->stop($eventName);
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    protected function runWorker(WorkerInterface $worker, EventInterface $event)
    {
        $workerName = sprintf('%s::%s', $worker->getListenerClass(), $worker->getMethodName());
        $this->stopwatch->start($workerName);
        $result = parent::runWorker($worker, $event);
        $this->stopwatch->stop($workerName);
        return $result;
    }

    /**
     * @param Stopwatch $stopwatch
     *
     * @return $this
     */
    public function setStopwatch(Stopwatch $stopwatch)
    {
        $this->stopwatch = $stopwatch;

        return $this;
    }
}