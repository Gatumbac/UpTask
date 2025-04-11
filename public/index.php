<?php 
require_once __DIR__ . '/../includes/app.php';

use Controllers\DashboardController;
use Controllers\LoginController;
use Controllers\TaskController;
use MVC\Router;

$router = new Router();

//Public Zone
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

//Private Zone
$router->get('/dashboard', [DashboardController::class, 'index']);
$router->get('/crear-proyecto', [DashboardController::class, 'createProject']);
$router->post('/crear-proyecto', [DashboardController::class, 'processProjectCreation']);
$router->get('/proyecto', [DashboardController::class, 'project']);
$router->get('/perfil', [DashboardController::class, 'profile']);

//API for TASKS
$router->get('/api/tareas', [TaskController::class, 'index']);
$router->post('/api/tarea', [TaskController::class, 'create']);
$router->get('/api/tarea/actualizar', [TaskController::class, 'update']);
$router->get('/api/tarea/eliminar', [TaskController::class, 'delete']);




$router->checkRoute();

