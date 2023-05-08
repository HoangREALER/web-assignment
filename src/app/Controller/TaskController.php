<?php

namespace App\Controller;

use App\Model\User;
use App\Model\Task;
use App\Util\Database\Database;


class TaskController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->authentication();
    }
    function get() // GET
    {
        //TODO: For the employee, get all the tasks that assigned to this user.
        //      For da boss, get all the tasks that this boss have already assigned, including finished and unfinished ones.
        $user = User::findById($this->auth()->id);
        $arr_tasks = Task::findByAssigner($user->id);
        $this->data['role'] = $user->id;
        $this->data['tasks'] = $arr_tasks;
        $this->view('task');
    }

    function submit() // POST
    {
        //TODO: For the employee, an employee can perform the task, the result will go to task_performed to finish and submit the task.
        if (isset($_POST['task_performed']) && isset($_POST['task_id']) && gettype($_POST['task_id']) === 'integer') 
        {
            return $this->performTask($_POST['task_id'], $_POST['task_performed']);
        }
        $this->get();
    }

    function performTask($task_id = 0, $performance = '') 
    {
        $task = Task::findById($task_id);
        $assignee = $this->auth();
        if (isset($task)) 
        {
            if ($assignee->id === $task->assignee_id) 
            {
                $task->task_performed = $performance;
                $task->update();
            }
            else 
            {
                $this->data['error'] = 'You don\'t have permission';
            }
        } 
        else 
        {
            $this->data['error'] = 'Task not found permission';
        }
        
    }

    function reviewTask() // POST
    {
        //TODO: For da boss, a boss can choose to approve, reject, return for redoing. -> Ông chia ra 3 cái function khác nhau cx đc.
    }

    function assignTask() // POST
    {
        //TODO: Create a task with task_name, assinee_id, task_description, deadline.
    }
    
}
