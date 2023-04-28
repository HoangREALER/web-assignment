<?php

namespace App\Controller;

use App\Model\User;


class ProductsController extends Controller
{
    function get()
    {
        $user = $this->auth();
        if (isset($user)) {
            header('location: index.php?page=home');
            die();
        }
        return $this->view('product');
    }

    function post()
    {
        $username = isset($_POST['username']) ? $_POST['username'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        $user = User::auth($username, $password);
        if (isset($user)) {
            $this->auth($user);
            echo json_encode(array('success' => true));
            return true;
        }
        // $this->data['error'] = "Lmao";
        echo json_encode(array('success' => false, 'error' => "Username or password incorrect"));
        return false;
    }

    function logout()
    {
        $this->sessionInvalidate();
        header('location: index.php?page=login');
    }
}
