<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/inscription/etape-1', 'UserController::inscriptionStep1');
$routes->post('/inscription/etape-1', 'UserController::storeStep1');
$routes->get('/inscription/etape-2', 'UserController::inscriptionStep2');
$routes->post('/inscription/etape-2', 'UserController::storeStep2');
