<?php
namespace Controllers;
use MVC\Router;
use Model\User;

class LoginController {
    public static function login(Router $router) {
        $router->render('auth/login', [
            'title' => 'Iniciar Sesión'
        ]);
    }

    public static function processLogin(Router $router) {
        $router->render('auth/login');
    }

    public static function logout() {
    }

    public static function signUp(Router $router) {
        $user = new User();
        
        $router->render('auth/signup', [
            'title' => 'Crea tu cuenta',
            'user' => $user
        ]);
    }

    public static function processSignup(Router $router) {
        $user = new User($_POST);
        $alerts = $user->validate();

        $router->render('auth/signup', [
            'title' => 'Crea tu cuenta',
            'user' => $user,
            'alerts' => $alerts
        ]);
    }

    public static function forgotPassword(Router $router) {
        $router->render('auth/forgot-password', [
            'title' => 'Olvide Password'
        ]);
    }

    public static function processForgotPassword() {
    }

    public static function resetPassword(Router $router) {
        $router->render('auth/reset-password', [
            'title' => 'Reestablecer contraseña'
        ]);
    }

    public static function processResetPassword() {
    }

    public static function emailInstructions(Router $router) {
        $router->render('auth/email-instructions', [
            'title' => 'Revisa tu correo'
        ]);
    }

    public static function confirmAccount(Router $router) {
        $router->render('auth/confirm-account', [
            'title' => 'Verificar cuenta'
        ]);
    }

}