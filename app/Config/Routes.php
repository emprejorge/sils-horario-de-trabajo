<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::index');
$routes->get('login', 'Auth::login');
$routes->get('fake-login', 'Auth::fakeLogin');
$routes->get('auth/google', 'Auth::google');
$routes->get('auth/google/callback', 'Auth::callback');
$routes->get('logout', 'Auth::logout');

$routes->get('dashboard', 'Dashboard::index');

$routes->get('/horario', 'Horario::index');
$routes->post('/horario/save', 'Horario::save');

$routes->get('/admin/usuarios', 'Admin::usuarios');
$routes->get('/admin/horario/(:num)', 'Admin::verHorario/$1');
$routes->post('/admin/horario/save/(:num)', 'Admin::guardarHorario/$1');