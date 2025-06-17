<?php

use App\Controllers\AuthController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', function () {
    return redirect()->route('login');
});

$routes->group('', ['filter' => 'guest'], function (RouteCollection $routes) {
    $routes->get('login', [AuthController::class, 'showLoginPage'], ['as' => 'login']);
    $routes->get('login/comment/(:segment)', [AuthController::class, 'showLoginCommentPage'], ['as' => 'login.comment']);
    $routes->post('login/comment/(:segment)', [AuthController::class, 'loginComment'], ['as' => 'login.comment.post']);
    $routes->post('login', [AuthController::class, 'login'], ['as' => 'login.post', 'filter' => 'throttle:5,1']);
    $routes->get('register', [AuthController::class, 'showRegisterPage'], ['as' => 'register']);
    $routes->post('register', [AuthController::class, 'register'], ['as' => 'register.post']);
});
