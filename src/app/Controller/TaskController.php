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
        $this->data['role'] = $user->role_id;
        
        if ($this->data['role'] === 0) {
            $arr_tasks = Task::findByAssigner($user->id);
            $arr_tasks = array_reverse($arr_tasks);
            foreach($arr_tasks as $task)
            {
                $task->assigner = User::findById($task->assigner_id);
                $task->assignee = User::findById($task->assignee_id);
            }
            $this->data['tasks'] = $arr_tasks;
            $this->view('task-for-boss');
        }
        else { 
            $arr_tasks = Task::findByAssignee($user->id);
            $arr_tasks = array_reverse($arr_tasks);
            $task_undone = array(); $task_done = array();
            foreach($arr_tasks as $task)
            {
                $task->assigner = User::findById($task->assigner_id);
                $task->assignee = User::findById($task->assignee_id);
                if ($task->task_result === '' or  $task->task_result === 'Returned')
                {
                    $task_undone[] = $task;
                }
                else
                {
                    $task_done[] = $task;
                }
            }
            $this->data['task_undone'] = $task_undone;
            $this->data['task_done'] = $task_done;
            $this->view('task');
        }
    }

    function submit() // POST
    {
        //TODO: For the employee, an employee can perform the task, the result will go to task_performed to finish and submit the task.
        if (isset($_POST['task_performed']) && isset($_POST['task_id'])) 
        {
            return $this->performTask($_POST['task_id'], $_POST['task_performed']);
        }
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
                if ($task->task_result === "Returned")
                {
                    $task->task_result = "";
                }
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
        if (isset($_POST['action']) && isset($_POST['task_id'])) 
        {
            if ($_POST['action'] === "approve")
            {
                return $this->approveTask(intval($_POST['task_id']));
            } 
            elseif ($_POST['action'] === "reject") 
            {
                return $this->rejectTask(intval($_POST['task_id']));
            }
            elseif ($_POST['action'] === "redo") 
            {
                return $this->returnTask(intval($_POST['task_id']));
            }
        }
        echo json_encode(array('success'=> false));
    }

    function approveTask($id)
    {
        $task = Task::findById($id);
        if(isset($task))
        {
            if ($this->auth()->id === $task->assigner_id && $task->task_performed !== '') 
            {
                $task->task_result = "Approved";
                $task->update();
            }
            else 
            {
                $this->data['error'] = 'You don\'t have permission';
            }
        }
    }

    function rejectTask($id)
    {
        $task = Task::findById($id);
        if(isset($task))
        {
            if ($this->auth()->id === $task->assigner_id && $task->task_performed !== '') 
            {
                $task->task_result = "Rejected";
                $task->update();
            }
            else 
            {
                $this->data['error'] = 'You don\'t have permission';
            }
        }
    }

    function returnTask($id)
    {
        $task = Task::findById($id);
        if(isset($task))
        {
            if ($this->auth()->id === $task->assigner_id && $task->task_performed !== '') 
            {
                $task->task_result = "Returned";
                $task->update();
            }
            else 
            {
                $this->data['error'] = 'You don\'t have permission';
            }
        }
    }

    function getFormToAssignTask()
    {
        if ($this->auth()->role_id == 0)
        { 
            $this->data['assign'] = '';
            $this->view('assign-task');
        }
        else
        {
            echo "Nhầm chỗ bạn êi";
        }
    }

    function assignTask() // POST
    {
        //TODO: Create a task with task_name, assinee_id, task_description, deadline.
        $data = array();
        $data['task_name'] = isset($_POST['task_name']) && $_POST['task_name'] !== "" ? $_POST['task_name'] : 'Task With No Name';
        $assignee_name = isset($_POST['assignee_name']) && $_POST['assignee_name'] !== "" ? $_POST['assignee_name'] : '';
        $data['task_description'] = isset($_POST['task_description']) ? $_POST['task_description'] : '';
        $data['deadline']  = isset($_POST['deadline']) ? date("Y-m-d h:m:s", strtotime($_POST['deadline'])) : '';
        echo $data['deadline'];
        $assignee = User::findByUsername($assignee_name);
        $data['assigner_id'] = $this->auth()->id;
        $data['assignee_id'] = isset($assignee) ? $assignee->id : 2;
        $task = new Task($data);
        $task->save();
    }
    
}
