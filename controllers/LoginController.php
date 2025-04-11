<?php
namespace Controllers;
use MVC\Router;
use Model\User;
use Classes\Email;

class LoginController {
    public static function login(Router $router) {
        $user = new User();

        $router->render('auth/login', [
            'title' => 'Iniciar Sesión',
            'user' => $user
        ]);
    }

    public static function processLogin(Router $router) {
        $formUser = new User($_POST);
        $formUser->validateLogin();
        $alerts = User::getAlerts();
        $auth = false;

        if(empty($alerts)) {
            $user = User::where('email', $formUser->getEmail());
            if (!is_null($user)) {
                $auth = $user->checkCredentials($formUser->getPassword());
            } else {
                User::setAlert('error', 'El usuario no está registrado');
            }

            if($auth) {
                $user->initializeSession();
            }

            $alerts = User::getAlerts();
        }

        $router->render('auth/login', [
            'title' => 'Iniciar Sesión',
            'alerts' => $alerts,
            'user' => $formUser
        ]);
    }

    public static function logout() {
        session_start();
        $_SESSION = [];
        redirect('/');
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

        if (empty($alerts)) {
            if($user->validateUniqueUser()) {
                $user->hashPassword();
                $user->generateToken();

                $email = new Email($user->getEmail(), $user->getName(), $user->getToken());
                $email->sendAccountConfirmation();

                if($user->save()) {
                    redirect('/revisar-correo');
                }
            }
            $alerts = User::getAlerts();
        }

        $router->render('auth/signup', [
            'title' => 'Crea tu cuenta',
            'user' => $user,
            'alerts' => $alerts
        ]);
    }

    public static function forgotPassword(Router $router) {
        $user = new User();

        $router->render('auth/forgot-password', [
            'title' => 'Olvide Password',
            'user' => $user
        ]);
    }

    public static function processForgotPassword(Router $router) {
        $formUser = new User($_POST);
        $formUser->validateEmail();
        $alerts = User::getAlerts();

        if (empty($alerts)) {
            $user = User::where('email', $formUser->getEmail());
            if (!is_null($user) && $user->isConfirmed()) {
                $user->generateToken();

                $email = new Email($user->getEmail(), $user->getName(), $user->getToken());
                $email->sendPasswordInstructions();

                if ($user->save()) {
                    User::setAlert('success', 'Hemos enviado las instrucciones a tu correo');
                }
            } else {
                User::setAlert('error', 'El usuario no existe o no está confirmado');
            }

            $alerts = User::getAlerts();
        }

        $router->render('auth/forgot-password', [
            'title' => 'Olvide Password',
            'user' => $formUser,
            'alerts' => $alerts
        ]);
    }

    public static function resetPassword(Router $router) {
        $token = s($_GET['token']) ?? '';
        verify($token, '/');
        $user = User::where('token', $token);
        $mostrar = true;

        if (is_null($user)) {
            User::setAlert('error', 'Token no válido');
            $mostrar = false;
        } 

        $alerts = User::getAlerts();

        $router->render('auth/reset-password', [
            'title' => 'Reestablecer contraseña',
            'alerts' => $alerts,
            'mostrar' => $mostrar
        ]);
    }

    public static function processResetPassword(Router $router) {
        $token = s($_GET['token']) ?? '';
        $user = User::where('token', $token);
        verify($user, '/');

        $formUser = new User($_POST);
        $formUser->validatePassword();
        $alerts = User::getAlerts();

        if (empty($alerts)) {
            $user->setPassword($formUser->getPassword());
            $user->hashPassword();

            $user->setToken(null);
            if($user->save()) {
                redirect('/');
            }
        }

        $router->render('auth/reset-password', [
            'title' => 'Reestablecer contraseña',
            'alerts' => $alerts,
            'mostrar' => true
        ]);
    }

    public static function emailInstructions(Router $router) {
        $router->render('auth/email-instructions', [
            'title' => 'Revisa tu correo'
        ]);
    }

    public static function confirmAccount(Router $router) {
        $token = s($_GET['token']) ?? '';
        verify($token, '/');
        $user = User::where('token', $token);

        if (is_null($user)) {
            User::setAlert('error', 'Token no válido');
        } else {
            $user->setToken(null);
            $user->setConfirmed('1');
            
            if($user->save()) {
                User::setAlert('success', 'Cuenta Confirmada Correctamente');
            }
        }

        $alerts = User::getAlerts();

        $router->render('auth/confirm-account', [
            'title' => 'Verificar cuenta',
            'alerts' => $alerts
        ]);
    }

}