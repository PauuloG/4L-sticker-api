<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('donation_index', new Route(
    '/',
    array('_controller' => 'AppBundle:Donation:index'),
    array(),
    array(),
    '',
    array(),
    array('GET')
));

$collection->add('donation_new', new Route(
    '/new',
    array('_controller' => 'AppBundle:Donation:new'),
    array(),
    array(),
    '',
    array(),
    array('GET', 'POST')
));

$collection->add('donation_processed', new Route(
    'processed/{id}',
    array('_controller' => 'AppBundle:Donation:processed'),
    array(),
    array(),
    '',
    array(),
    array('GET', 'POST')
));

return $collection;
