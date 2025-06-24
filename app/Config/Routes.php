<?php

use App\Controllers\AuthController;
use App\Controllers\BackgroundWorkerController;
use App\Controllers\EmailVerficationController;
use App\Controllers\ForgotPasswordController;
use App\Controllers\HomeController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', function () {
    return redirect()->route('login');
});
$routes->get('test-async', [EmailVerficationController::class, 'testAsync']);

$routes->post('bg_worker.php', [BackgroundWorkerController::class, 'index']);

$routes->get('welcome', [HomeController::class, 'index'], ['as' => 'welcome', 'filter' => ['auth', 'email_verified']]);

$routes->get('email-required', [EmailVerficationController::class, 'index'], ['as' => 'email.required', 'filter' => 'auth']);
$routes->post('email/verify', [EmailVerficationController::class, 'send'], ['as' => 'email.verify.send']);
$routes->get('email/verify/(:segment)', [EmailVerficationController::class, 'verify'], ['as' => 'email.verify', 'filter' => 'auth']);

$routes->group('',  function (RouteCollection $routes) {
    $routes->get('login', [AuthController::class, 'showLoginPage'], ['as' => 'login']);
    $routes->get('login/comment/(:segment)', [AuthController::class, 'showLoginCommentPage'], ['as' => 'login.comment']);
    $routes->post('login/comment/(:segment)', [AuthController::class, 'loginComment'], ['as' => 'login.comment.post']);
    $routes->post('login', [AuthController::class, 'login'], ['as' => 'login.post', 'filter' => 'throttle:5,1']);
    $routes->get('register', [AuthController::class, 'showRegisterPage'], ['as' => 'register']);
    $routes->post('register', [AuthController::class, 'register'], ['as' => 'register.post']);
});

$routes->post('logout', [AuthController::class, 'logout'], ['as' => 'logout.post']);

$routes->group('forgot-password', function (RouteCollection $routes) {
    $routes->get('', [ForgotPasswordController::class, 'index'], ['as' => 'forgot-password']);
    $routes->post('', [ForgotPasswordController::class, 'send'], ['as' => 'forgot-password.post']);
    $routes->get('reset/(:segment)', [ForgotPasswordController::class, 'show'], ['as' => 'password.reset']);
    $routes->put('reset/(:segment)', [ForgotPasswordController::class, 'update'], ['as' => 'password.update']);
});

$routes->get('password/reset/(:segment)', [ForgotPasswordController::class, 'show'], ['as' => 'password.reset.get']);
