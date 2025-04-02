<?php 
require_once __DIR__ . '/../includes/app.php';

use Controllers\LoginController;
use MVC\Router;

$router = new Router();

$router->get('/', [LoginController::class, 'login']);
$router->post('/', [LoginController::class, 'processLogin']);
$router->get('/logout', [LoginController::class, 'logout']);

$router->get('/crear-cuenta', [LoginController::class, 'signup']);
$router->post('/crear-cuenta', [LoginController::class, 'processSignup']);

$router->get('/olvide-password', [LoginController::class, 'forgotPassword']);
$router->post('/olvide-password', [LoginController::class, 'processForgotPassword']);

$router->get('/resetear-password', [LoginController::class, 'resetPassword']);
$router->post('/resetear-password', [LoginController::class, 'processResetPassword']);

$router->get('/revisar-correo', [LoginController::class, 'emailInstructions']);
$router->get('/confirmar-cuenta', [LoginController::class, 'confirmAccount']);


$router->checkRoute();

