<?php
namespace Controllers;

use Model\Project;
use Model\Task;

class TaskController {
    public static function index() {
        session_start();
        isAuth();

        $project_url = $_GET['id'] ?? '';
        $project = Project::where('url', $project_url);
        if(is_null($project) || $project->getUserId() != $_SESSION['id']) {
            redirect('/dashboard');
        }
        
        $tasks = Task::belongsTo('project_id', $project->getId());
        echo json_encode(['tasks' => $tasks, 'result'=>true], JSON_UNESCAPED_UNICODE);
    }

    public static function create() {
        session_start();
        isAuth();

        $project = Project::where('url', $_POST['project_id']);

        if (is_null($project) || $project->getUserId() != $_SESSION['id']) {
            $response = [
                'type' => 'error',
                'message' => 'Hubo un error al agregar la tarea'
            ];
        } else {
            $task = new Task($_POST);
            $task->setProjectId($project->getId());
            $dbResult = $task->save();
            $response = [
                'type' => $dbResult['result'] ? 'success' : 'error',
                'message' => $dbResult['result'] ? 'Tarea agregada exitosamente' : 'Error al insertar el registro' ,
                'id' => $dbResult['id'],
                'projectId' => $project->getId()
            ];
        }

        echo json_encode($response);
    }

    public static function update() {
        
    }

    public static function delete() {
        
    }
}