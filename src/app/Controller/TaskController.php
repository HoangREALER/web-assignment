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
    function get()
    {
        //TODO: For the employee, get all the tasks that assigned to this user.
        //      For da boss, get all the tasks that this boss have already assigned, including finished and unfinished ones.
    }

    function post()
    {
        //TODO: For the employee, an employee can choose to finish and report.
        //      For da boss, get all the tasks that this boss have already assigned, including finished and unfinished ones.
    }

    function logout()
    {
        $this->sessionInvalidate();
        header('location: index.php?page=login');
    }
}
