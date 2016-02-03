<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('sticker_index', new Route(
    '/',
    array('_controller' => 'AppBundle:Sticker:index'),
    array(),
    array(),
    '',
    array(),
    array('GET')
));

$collection->add('sticker_new', new Route(
    '/new',
    array('_controller' => 'AppBundle:Sticker:new'),
    array(),
    array(),
    '',
    array(),
    array('GET', 'POST')
));

return $collection;
