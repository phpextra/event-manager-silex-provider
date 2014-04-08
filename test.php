<?php

use PHPExtra\EventManager\Silex\Event\RequestEvent;

require_once(__DIR__ . '/vendor/autoload.php');

$app = new Silex\Application(array('debug' => true));

$app->register(new \PHPExtra\EventManager\Silex\EventManagerProvider());
$app->get('/',function(){
//        echo "controller";
    return 'controller';
});


###########
$em = $app['event_manager'];
/** @var $em \PHPExtra\EventManager\EventManagerInterface */

$em->addListener(new \PHPExtra\EventManager\Listener\AnonymousListener(function(RequestEvent $event){
    echo 'listener';
}));
############



$app->run();