<?php

namespace App\Controller;

use App\Model\User;


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
    }

    function sumit() // POST
    {
        //TODO: For the employee, an employee can perform the task, the result will go to task_performed to finish and submit the task.
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
