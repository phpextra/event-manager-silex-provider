<?php

use PHPExtra\EventManager\Silex\Event\RequestEvent;

include(__DIR__ . '/vendor/autoload.php');

$app = new Silex\Application(array('debug' => true));

$app->register(new \PHPExtra\EventManager\Silex\EventManagerProvider());
$app->get('/',function(){
    return 'asd';
});


###########
$em = $app['event_manager'];
/** @var $em \PHPExtra\EventManager\EventManagerInterface */

$em->addListener(new \PHPExtra\EventManager\Listener\AnonymousListener(function(RequestEvent $event){
    echo 'test';
}));
############



$app->run();