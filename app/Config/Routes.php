<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/formulaire', 'AuthController::form');
$routes->post('/login', 'AuthController::login');   
$routes->get('/index', 'RegimeController::index');
