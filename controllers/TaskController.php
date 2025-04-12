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
        $response = self::verifyValidProject($_POST);

        if ($response['result']) {
            $project = $response['project'];
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
        $response = self::verifyValidProject($_POST);

        if ($response['result']) {
            $project = $response['project'];
            $task = new Task($_POST);
            $task->setProjectId($project->getId());
            $dbResult = $task->save();
            $response = [
                'type' => $dbResult ? 'success' : 'error',
                'message' => $dbResult ? 'Tarea actualizada exitosamente' : 'Error al actualizar el registro' ,
                'id' => $task->getId(),
                'projectId' => $project->getId()
            ];
        }

        echo json_encode($response);
    }

    public static function delete() {
        $response = self::verifyValidProject($_POST);

        if ($response['result']) {
            $project = $response['project'];
            $task = Task::where('id', $_POST['id']);
            if (!is_null($task)) {
                $dbResult = $task->delete();
                $response = [
                    'type' => $dbResult ? 'success' : 'error',
                    'message' => $dbResult ? 'Tarea eliminada exitosamente' : 'Error al eliminar el registro' ,
                    'id' => $task->getId(),
                    'projectId' => $project->getId()
                ];
            }

        }
        echo json_encode($response);
    }

    public static function verifyValidProject($post) {
        session_start();    
        isAuth();

        $project = Project::where('url', $post['project_id']);

        if (is_null($project) || $project->getUserId() != $_SESSION['id']) {
            $response = [
                'type' => 'error',
                'message' => 'Hubo un error al obtener los datos',
                'result' => false
            ];
        } else {
            $response = [
                'result' => true,
                'project' => $project
            ];
        }

        return $response;
    }
}