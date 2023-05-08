<?php

namespace App\Controller;

use App\Model\User;
use App\Model\Role;
use App\Model\Permission;
use App\Model\Task;


class MessageController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->authentication();
    }
    function get()
    {
        // TODO: Get all the message that being sent to the user
    }

    function post()
    {
        // TODO: Send message
    }
}
