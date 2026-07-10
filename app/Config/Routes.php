<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('map', 'Map::index');

// Auth Routes
$routes->group('auth', function ($routes) {
    $routes->get('login', 'Auth::login');
    $routes->post('attemptLogin', 'Auth::attemptLogin');
    $routes->get('logout', 'Auth::logout');
});

// Admin Routes (Protected)
$routes->group('dashboard', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Dashboard::index');
});

$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    // RDTR CRUD
    $routes->get('rdtr', 'Admin\RdtrController::index');
    $routes->get('rdtr/create', 'Admin\RdtrController::create');
    $routes->post('rdtr/store', 'Admin\RdtrController::store');
    $routes->get('rdtr/edit/(:num)', 'Admin\RdtrController::edit/$1');
    $routes->post('rdtr/update/(:num)', 'Admin\RdtrController::update/$1');
    $routes->get('rdtr/delete/(:num)', 'Admin\RdtrController::delete/$1');
    $routes->get('rdtr/export', 'Admin\RdtrController::exportPdf');
    $routes->post('rdtr/add-activity', 'Admin\RdtrController::addActivity');
    $routes->post('rdtr/delete-activity/(:num)', 'Admin\RdtrController::deleteActivity/$1');

    // RTRW CRUD
    $routes->get('rtrw', 'Admin\RtrwController::index');
    $routes->get('rtrw/create', 'Admin\RtrwController::create');
    $routes->post('rtrw/store', 'Admin\RtrwController::store');
    $routes->get('rtrw/edit/(:num)', 'Admin\RtrwController::edit/$1');
    $routes->post('rtrw/update/(:num)', 'Admin\RtrwController::update/$1');
    $routes->get('rtrw/delete/(:num)', 'Admin\RtrwController::delete/$1');

    // Settings
    $routes->get('settings', 'Admin\SettingsController::index');
    $routes->post('settings/update', 'Admin\SettingsController::update');
    $routes->post('settings/add-hero', 'Admin\SettingsController::addHeroImage');
    $routes->get('settings/delete-hero/(:num)', 'Admin\SettingsController::deleteHeroImage/$1');
    $routes->get('settings/delete-logo/(:any)', 'Admin\SettingsController::deleteLogo/$1');

    // Users
    $routes->get('users', 'Admin\UserController::index');
    $routes->get('users/create', 'Admin\UserController::create');
    $routes->post('users/store', 'Admin\UserController::store');
    $routes->get('users/edit/(:num)', 'Admin\UserController::edit/$1');
    $routes->post('users/update/(:num)', 'Admin\UserController::update/$1');
    $routes->get('users/delete/(:num)', 'Admin\UserController::delete/$1');

    // Audit Logs (Admin Only)
    $routes->get('audit-logs', 'Admin\AuditLogController::index', ['filter' => 'auth']);
    $routes->get('audit-logs/clear', 'Admin\AuditLogController::clear', ['filter' => 'auth']);
    // ... other methods
});

// API Routes
$routes->group('api', function ($routes) {
    $routes->post('spatial/check', 'Api\Spatial::check');
    $routes->get('spatial/layers', 'Api\Spatial::layers');
    $routes->post('spatial/validate-kbli', 'Api\Spatial::validateKBLI');
    $routes->get('spatial/export-analysis', 'Api\Spatial::exportAnalysis');

    // RDTR Activities
    $routes->get('rdtr/zone/(:num)/activities', 'Api\RdtrActivity::getByZone/$1');

    // Protected API for RDTR/RTRW Management if checking from external or AJAX admin
    $routes->resource('rdtr', ['controller' => 'Api\Rdtr', 'filter' => 'auth']);
    $routes->resource('rtrw', ['controller' => 'Api\Rtrw', 'filter' => 'auth']);
});

// Media Serving (Public Access for registered assets)
$routes->get('media/serve/(:any)', 'Media::serve/$1');
$routes->get('media/download/(:any)', 'Media::download/$1');