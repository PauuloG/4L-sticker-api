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

$collection->add('donation_show', new Route(
    '/{id}/show',
    array('_controller' => 'AppBundle:Donation:show'),
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

$collection->add('donation_edit', new Route(
    '/{id}/edit',
    array('_controller' => 'AppBundle:Donation:edit'),
    array(),
    array(),
    '',
    array(),
    array('GET', 'POST')
));

$collection->add('donation_delete', new Route(
    '/{id}/delete',
    array('_controller' => 'AppBundle:Donation:delete'),
    array(),
    array(),
    '',
    array(),
    array('DELETE')
));

return $collection;
