<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Dashboard::index');
$routes->get('/register', 'Auth::register');
$routes->post('register', 'Auth::processRegister');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::processLogin');
$routes->get('logout', 'Auth::logout');
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('family/choose', 'Family::choose');
    $routes->post('family/handle', 'Family::handle');
    $routes->get('family/setActive/(:num)', 'Family::setActive/$1');
    $routes->get('dashboard', 'Dashboard::index');
    $routes->get('/reminders', 'ReminderController::index');
    $routes->post('/reminders/save', 'ReminderController::save');
    $routes->get('/reminders/delete/(:num)', 'ReminderController::delete/$1');
    $routes->get('/warranties', 'WarrantyController::index');
    $routes->post('warranties/save', 'WarrantyController::store');
    $routes->get('warranties/delete/(:num)', 'WarrantyController::delete/$1');
    $routes->get('/members', 'FamilyMembersController::index');
    $routes->post('members/save', 'FamilyMembersController::save');
    $routes->get('members/delete/(:num)', 'FamilyMembersController::delete/$1');
});

$routes->get('cron/send-reminder-mails', 'CronController::sendReminderEmails');
