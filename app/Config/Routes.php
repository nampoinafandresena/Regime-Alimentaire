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

// routes dashboard back-office
$routes->get('/bo/dashboard/general', 'BackOfficeController::index');

$routes->get('/bo/dashboard/regime', 'BackOfficeController::crud_regime');
$routes->post('/bo/dashboard/regime/delete/(:num)', 'BackOfficeController::deleteRegimeAjax/$1');
$routes->get('/bo/dashboard/regime/get/(:num)', 'BackOfficeController::getRegimeAjax/$1');
$routes->post('/bo/dashboard/regime/create', 'BackOfficeController::createRegimeAjax');
$routes->put('/bo/dashboard/regime/update/(:num)', 'BackOfficeController::updateRegimeAjax/$1');

$routes->get('/bo/dashboard/sport', 'BOSportController::index');
$routes->post('/bo/dashboard/sport/delete/(:num)', 'BOSportController::deleteSportAjax/$1');
$routes->get('/bo/dashboard/sport/get/(:num)', 'BOSportController::getSportAjax/$1');
$routes->post('/bo/dashboard/sport/create', 'BOSportController::createSportAjax');
$routes->put('/bo/dashboard/sport/update/(:num)', 'BOSportController::updateSportAjax/$1');

$routes->get('/bo/dashboard/code', 'BOCodeController::index');
$routes->post('/bo/dashboard/code/delete/(:num)', 'BOCodeController::deleteCodeAjax/$1');
$routes->get('/bo/dashboard/code/get/(:num)', 'BOCodeController::getCodeAjax/$1');
$routes->post('/bo/dashboard/code/create', 'BOCodeController::createCodeAjax');
$routes->put('/bo/dashboard/code/update/(:num)', 'BOCodeController::updateCodeAjax/$1');

$routes->get('/bo/dashboard/user', 'BackOfficeController::crud_user');
$routes->post('/bo/dashboard/user/delete/(:num)', 'BackOfficeController::deleteUserAjax/$1');