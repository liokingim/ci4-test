<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

$routes->get('api/search', 'JapaneseDocumentApiController::search');
$routes->get('search', 'JapaneseDocumentController::search');

$routes->get('posts', 'PostController::index');
$routes->post('post', 'PostController::create');
$routes->get('post/(:num)', 'PostController::show/$1');
$routes->post('post/(:num)', 'PostController::update/$1');
$routes->delete('post/(:num)', 'PostController::delete/$1');

$routes->group('api', ['namespace' => 'App\Controllers\Api'], function ($routes) {
    $routes->get('example', 'ExampleApiController::index');
});

$routes->get('/', 'HomeController::index');
$routes->get('session', 'SessionController::index');

$routes->group('auth', function ($routes) {
    $routes->get('facebook', 'AuthController::facebook');
    $routes->get('facebook/callback', 'AuthController::facebookCallback');
    $routes->get('google', 'AuthController::google');
    $routes->get('google/callback', 'AuthController::googleCallback');
    $routes->get('logout', 'AuthController::logout');
    $routes->get('facebook/sns', 'SNSAuthController::authenticateWithFacebook');
    $routes->get('google/sns', 'SNSAuthController::authenticateWithGoogle');
});

$routes->get('/get_bank_info', 'BankController::index');

$routes->get('/bank/deposit', 'BankController::deposit');
$routes->get('/bank/withdraw', 'BankController::withdraw');

$routes->get('/bank/balance', 'BankController::balance');

$routes->get('bank/account', 'BankController::accountInfo');
$routes->get('bank/transactions', 'BankController::transactionHistory');
$routes->post('bank/loan', 'BankController::loan');

$routes->post('/validate', 'ValidationController::index');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
