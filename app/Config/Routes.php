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
$routes->get('/formulaire', 'AuthController::form');
$routes->post('/login', 'AuthController::login');   
$routes->get('/index', 'RegimeController::index');

// routes dashboard
$routes->get('/bo/dashboard/general', 'BackOfficeController::index');
$routes->get('/bo/dashboard/regime', 'BackOfficeController::crud_regime');
$routes->get('/bo/dashboard/sport', 'BackOfficeController::crud_sport');
$routes->get('/bo/dashboard/code', 'BackOfficeController::crud_code');
$routes->get('/bo/dashboard/user', 'BackOfficeController::crud_user');
$routes->post('/bo/dashboard/user/delete/(:num)', 'BackOfficeController::deleteUserAjax/$1');
$routes->post('/bo/dashboard/regime/delete/(:num)', 'BackOfficeController::deleteRegimeAjax/$1');
$routes->get('/bo/dashboard/regime/get/(:num)', 'BackOfficeController::getRegimeAjax/$1');
$routes->post('/bo/dashboard/regime/create', 'BackOfficeController::createRegimeAjax');
$routes->put('/bo/dashboard/regime/update/(:num)', 'BackOfficeController::updateRegimeAjax/$1');