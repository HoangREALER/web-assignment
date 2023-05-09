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
        $this->data['firstname'] = $employee->firstname;
        $this->data['lastname'] = $employee->lastname;
        $this->data['email'] = $employee->email;
        $this->data['phone'] = $employee->phone;
        $this->data['profile'] = '';
        $this->view('profile');
    }

    function post() // POST
    {
        // TODO: receive post data to change employee info
        if (isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['phone'])) {
            $this->changeUserInfo($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['phone']);
        }
        header('Location: index.php?page=employee');
        die();
    }

    function changeUserInfo($firstname, $lastname, $email, $phone)
    {
        $employee = User::findById($this->auth()->id);
        $employee->firstname = $firstname;
        $employee->lastname = $lastname;
        $employee->email = $email;
        $employee->phone = $phone;
        $employee->update();
    }

    function employeeList()
    {
        // $user = User::findById($this->auth()->id);
        // if ($user->id === 0)
        // {
        //     //TODO: return employee list, $this->data['list']
        // }
        $this->data['employee'] = '';
        $this->view('employee');
    }
    //TODO: Add more functions if you want
}
