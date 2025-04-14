<?php
namespace Controllers;

use Model\User;
use MVC\Router;

class ProfileController {
    public static function profile(Router $router) {
        session_start();
        isAuth();

        $user = User::find($_SESSION['id']);

        $router->render('dashboard/profile', [
            'title' => 'Perfil',
            'cssDesign' => '',
            'userName' => $_SESSION['name'],
            'user' => $user
        ]);
    }

    public static function processProfileChanges(Router $router) {
        session_start();
        isAuth();

        $user = User::find($_SESSION['id']);
        $user->sync($_POST);
        $alerts = $user->validateUpdate();

        if (empty($alerts)) {
            $isUniqueEmail = $user->validateEmailUpdate();
            $user->setToken(null);
            if($isUniqueEmail && $user->save()) {
                $_SESSION['name'] = $user->getFullName();
                User::setAlert('success', 'Perfil actualizado correctamente');
            }
            $alerts = User::getAlerts();
        }


        $router->render('dashboard/profile', [
            'title' => 'Perfil',
            'cssDesign' => '',
            'userName' => $_SESSION['name'],
            'user' => $user,
            'alerts' => $alerts
        ]);
    }

    public static function password(Router $router) {
        session_start();
        isAuth();

        $router->render('dashboard/password-update', [
            'title' => 'Cambiar Contraseña',
            'cssDesign' => '',
            'userName' => $_SESSION['name']
        ]);
    }

    public static function processPasswordUpdate(Router $router) {
        session_start();
        isAuth();

        $formUser = new User($_POST);
        $formUser->validatePasswordForm();
        $alerts = User::getAlerts();

        if(empty($alerts)) {
            $dbUser = User::find($_SESSION['id']);

            if($dbUser->checkPasswordCredentials($formUser->getCurrentPassword())) {
                $dbUser->setPassword($formUser->getPassword());
                $dbUser->hashPassword();
                $dbUser->setToken(null);
                if($dbUser->save()) {
                    User::setAlert('success', 'Contraseña Actualizada Correctamente');
                }
            }
            $alerts = User::getAlerts();
        }

        $router->render('dashboard/password-update', [
            'title' => 'Cambiar Contraseña',
            'cssDesign' => '',
            'userName' => $_SESSION['name'],
            'alerts' => $alerts
        ]);
    }

}