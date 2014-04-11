<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;

// If you don't want to setup permissions the proper way, just uncomment the following PHP line
// read http://symfony.com/doc/current/book/installation.html#configuration-and-setup for more information
umask(0000);



$loader = require_once __DIR__.'/app/bootstrap.php.cache';
Debug::enable();

require_once __DIR__.'/app/AppKernel.php';

$kernel = new AppKernel('dev', true);
$kernel->loadClassCache();
$request = Request::createFromGlobals();
$kernel->boot();

$container = $kernel->getContainer();
$container->enterScope('request');
$container->set('request', $request);

// all our setup is done!!!!!!
$templating = $container->get('templating');

echo $templating->render(
    'EventBundle:Default:index.html.twig',
    array(
        'name' => 'Yoda',
        'count' => 5,
    )
);

use Yoda\EventBundle\Entity\Event;


$event = new Event();
$event->setName('Darth\'s surprise birthday party');
$event->setLocation('Deathstar');
$event->setTime(new \DateTime('tomorrow noon'));
$event->setDetails('Ha! Darth HATES surprises!!!!');

$em = $container->get('doctrine')->getManager();

$em = $container->get('doctrine')->getManager();
$em->persist($event);
$em->flush();