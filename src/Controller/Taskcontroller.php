<?php

namespace Controller;

use Model\Task;
use View\View;

class Taskcontroller
{
    public $view;

    public function __construct()
    {
        $this->view = new View(
            __DIR__ . '/../../template'
        );
    }

    public function render()
    {
        $task = new Task;
        $task = $task->findAll();
        $this->view->render('main/home.php', ['tasks' => $task]);
    }

    public static function addTask()
    {
        $task = new Task;
        $task->setTitle($_POST['title']);
        $task->setDescription($_POST['description']);
        $task->setStatus($_POST['status']);
        $task->save();
    }

    public static function getAllTasks()
    {
        $task = new Task;
        $response = $task->findAll();
        return $response;
    }

    public static function deleteTask($id)
    {
        $task = new Task;
        $task = $task->findOne($id);
        if (!$task) {
            return ['error' => 'Task not found'];
        }
        $task->delete();
        return ['success' => true];
    }

    public static function updateTask()
    {
        $task = new Task;
        $task->setTitle($_POST['title']);
        $task->setDescription($_POST['description']);
        $task->setStatus($_POST['status']);
        $task->save();
        return ['success' => true];
    }
    public static function getTask()
    {
        $task = new Task;
        $response = $task->findOne($_GET['id']);
        return $response;
    }
}
