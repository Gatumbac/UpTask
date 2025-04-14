<?php
namespace Controllers;

use Model\Project;
use Model\User;
use MVC\Router;

class DashboardController {
    public static function index(Router $router) {
        session_start();
        isAuth();

        $projects = Project::belongsTo('user_id', $_SESSION['id']);
        
        $router->render('dashboard/index', [
            'title' => 'Proyectos',
            'cssDesign' => '',
            'userName' => $_SESSION['name'],
            'projects' => $projects
        ]);
    }

    public static function createProject(Router $router) {
        session_start();
        isAuth();
        
        $router->render('dashboard/create-project', [
            'title' => 'Crear Proyecto',
            'cssDesign' => '',
            'userName' => $_SESSION['name']
        ]);
    }
    
    public static function processProjectCreation(Router $router) {
        session_start();
        isAuth();

        $project = new Project($_POST);
        $alerts = $project->validate();

        if (empty($alerts)) {
            $hash = md5(uniqid());
            $project->setUrl($hash);
            $project->setUserId($_SESSION['id']);

            if($project->save()) {
                redirect("/proyecto?id={$project->getUrl()}");
            }
        }

        $router->render('dashboard/create-project', [
            'title' => 'Crear Proyecto',
            'cssDesign' => '',
            'userName' => $_SESSION['name'],
            'alerts' => $alerts
        ]);
    }

    public static function project(Router $router) {
        session_start();
        isAuth();

        $projectId = $_GET['id'] ?? '';
        $project = self::validateProject($projectId, $_SESSION['id']);

        $router->render('dashboard/project', [
            'title' => $project->getName(),
            'cssDesign' => '',
            'userName' => $_SESSION['name'],
        ]);
    }

    public static function validateProject($projectId, $userId) {
        $project = Project::where('url', $projectId);
        if (is_null($project) || $project->getUserId() != $userId) {
            redirect('/dashboard');
        } 
        return $project;
    }
}