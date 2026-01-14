<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Office Management
$routes->get('offices', 'Home::offices');
$routes->get('addoffice', 'Home::addoffice');
$routes->post('saveoffice', 'Home::saveoffice');
$routes->get('editoffice/(:num)', 'Home::editoffice/$1');
$routes->post('updateoffice', 'Home::updateoffice');
$routes->get('deleteoffice/(:num)', 'Home::deleteoffice/$1');

// Authentication
$routes->get('login', 'Home::login');
$routes->post('savelogin', 'Home::savelogin');
$routes->get('logout', 'Home::logout');
$routes->get('dashboard', 'Home::dashboard');

// User Management
$routes->get('users', 'Home::users');
$routes->get('adduser', 'Home::adduser');
$routes->post('saveuser', 'Home::saveUser'); // Note: 'saveuser' should point to 'saveUser' (camelCase)
$routes->get('edituser/(:num)', 'Home::edituser/$1');
$routes->post('updateuser/(:num)', 'Home::updateUser/$1');
$routes->get('deleteuser/(:num)', 'Home::deleteuser/$1');

// Reports (Admin)
$routes->get('reports/pending', 'Reports::pending');
$routes->get('reports/completed', 'Reports::completed');
$routes->get('reports/history', 'Reports::history');

// Encoder Routes
$routes->get('my-documents', 'Encoder::myDocuments');
$routes->get('encoder/new', 'Encoder::newDocument');
$routes->post('encoder/save', 'Encoder::saveDocument');
$routes->get('encoder/history/(:num)', 'Encoder::history/$1');

// Staff Routes
$routes->get('staff', 'Staff::index');
$routes->get('staff/forward/(:num)', 'Staff::forward/$1');
$routes->post('staff/execute-forward', 'Staff::executeForward');
$routes->get('staff/complete/(:num)', 'Staff::complete/$1');
$routes->get('staff/history/(:num)', 'Staff::history/$1');

// admin
$routes->get('admin/documents', 'Admin::allDocuments');

// User Profile Routes
$routes->get('profile', 'Profile::index');
$routes->post('profile/update-details', 'Profile::updateDetails');
$routes->post('profile/update-password', 'Profile::updatePassword');