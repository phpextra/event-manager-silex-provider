<?php

include(__DIR__ . '/vendor/autoload.php');

$app = new Silex\Application(array('debug' => true));

$app->register(new \PHPExtra\EventManager\Silex\EventManagerProvider());

$app->get('/',function(){
        return 'asd';
    });

$app->run();