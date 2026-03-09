<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::index');
$routes->get('login', 'Auth::login');
$routes->get('auth/google', 'Auth::google');
$routes->get('auth/google/callback', 'Auth::callback');
$routes->get('logout', 'Auth::logout');

$routes->get('dashboard', 'Dashboard::index', ['filter' => 'auth']);

$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('horario', 'Horario::index');
    $routes->post('horario/save', 'Horario::save');
    $routes->get('horario/imprimir', 'Horario::imprimir');
});

$routes->group('admin', ['filter' => 'admin'], function ($routes) {
    $routes->get('/', 'Admin::index');
    $routes->get('usuarios', 'Admin::usuarios');
    $routes->get('horario/(:num)', 'Admin::verHorario/$1');
    $routes->post('horario/save/(:num)', 'Admin::guardarHorario/$1');
    $routes->get('imprimir/(:num)', 'Admin::imprimir/$1');
});
