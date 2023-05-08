<?php
namespace App\Controller;

use App\Model\User;

class RegisterController extends Controller
{
    function get()
    {
        $user = $this->auth();
        if (isset($user)) {
            header('location: index.php?page=home');
            die();
        }
        $this->data['register'] = ' ';
        return $this->view('register');
    }

    function post()
    {
        $data = array();
        $data['username'] = isset($_POST['username']) ? $_POST['username'] : '';
        $data['email']= isset($_POST['email']) ? $_POST['email'] : '';
        $data['password'] = isset($_POST['password']) ? ($_POST['password']) : '';
        $data['first_name'] = isset($_POST['first_name']) ? $_POST['first_name'] : '';
        $data['last_name'] = isset($_POST['last_name']) ? $_POST['last_name'] : '';
        $data['phone'] = isset($_POST['phone']) ? $_POST['phone'] : '';
        $user = new User($data);
        
        $validation = $user->validate();
        if($validation === true)
        {
            if(User::findByUsername($data['username']) != null)
            {
                echo json_encode(array('success'=> false, 'error' => 'Username exists'));
                return true;
            }
            else 
            {
                $user->save();
                $this->auth($user);
                echo json_encode(array('success'=> true));
            }
            return false;
        }
        echo json_encode(array('success' => false, 'error' => $validation));
        return true;
    }

}