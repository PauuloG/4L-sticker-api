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

$collection->add('sticker_show', new Route(
    '/{id}/show',
    array('_controller' => 'AppBundle:Sticker:show'),
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

$collection->add('sticker_edit', new Route(
    '/{id}/edit',
    array('_controller' => 'AppBundle:Sticker:edit'),
    array(),
    array(),
    '',
    array(),
    array('GET', 'POST')
));

$collection->add('sticker_delete', new Route(
    '/{id}/delete',
    array('_controller' => 'AppBundle:Sticker:delete'),
    array(),
    array(),
    '',
    array(),
    array('DELETE')
));

return $collection;
