<?php

include_once ROOT.'/components/Pagination.php';

class TaskController {
    public function actionIndex()
    {
        if (isset($_SESSION['user'])) {
            $user = User::getUserById($_SESSION['user']);
            setcookie('name', $user['name']);
            setcookie('email', $user['email']);
        }
        require_once(ROOT.'/views/task/view.php');
    }

    public function actionGetTasks($page)
    {
        setcookie('page', $page);
        $tasksList = Task::getTaskList($page);
        $total = Task::getTotalTasks();
        $pagination = new Pagination($total, $page, Task::SHOW_NUMBER, 'page-');
        echo include(ROOT.'/views/includes/table.php');
    }

    public function actionEditTask()
    {
        Task::editTask();
    }

    public function actionPostTask()
    {
        Task::postTask();
    }
}
