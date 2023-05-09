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
        // $this->authentication();
    }
    function get() // GET
    {
        // TODO: get Employee info, tasks and use template to display it. Reference HomeController@get
        $employee = User::findById($this->auth()->id);
        $this->data['first_name'] = $employee->first_name;
        $this->data['last_name'] = $employee->last_name;
        $this->data['email'] = $employee->email;
        $this->data['phone'] = $employee->phone;
        $this->view('employee');
    }

    function post() // POST
    {
        // TODO: receive post data to change employee info
        if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['phone'])) {
            $this->changeUserInfo($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['phone']);
        }
        header('Location: index.php?page=employee');
        die();
    }

    function changeUserInfo($first_name, $last_name, $email, $phone)
    {
        $this->data['first_name'] = $first_name;
        $this->data['last_name'] = $last_name;
        $this->data['email'] = $email;
        $this->data['phone'] = $phone;
    }
    //TODO: Add more functions if you want
}
