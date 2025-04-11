<?php
namespace Controllers;

use Model\Project;
use Model\Task;

class TaskController {
    public static function index() {
        $tasks = Task::belongsTo('project_id', '');
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
                'type' => 'success',
                'message' => 'Tarea agregada exitosamente',
                'id' => $dbResult['id']
            ];
        }

        echo json_encode($response);
    }

    public static function update() {
        
    }

    public static function delete() {
        
    }
}