<?php

namespace App\Controller;

use App\Model\User;
use App\Model\Role;
use App\Model\Permission;
use App\Model\Task;


class EmployeeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->authentication();
    }
    function get() // GET
    {
        // TODO: get Employee info, tasks and use template to display it. Reference HomeController@get
    }

    function post() // POST
    {
        // TODO: receive post data to change employee info
    }

    //TODO: Add more functions if you want
}
