<?php

namespace App\Model;

use App\Util\Database\Database;

class User
{
    public $id;
    public $username;
    public $password;
    public $email;
    public $first_name = '';
    public $last_name = '';
    public $phone = '';

    function __construct($params = array())
    {
        $this->id = isset($params['id']) ? $params['id'] : 0;
        $this->username = isset($params['username']) ? $params['username'] : '';
        $this->password = isset($params['password']) ? $params['password'] : '';
        $this->email = isset($params['email']) ? $params['email'] : '';
        $this->first_name = isset($params['first_name']) ? $params['first_name'] : '';
        $this->last_name = isset($params['last_name']) ? $params['last_name'] : '';
        $this->phone = isset($params['phone']) ? $params['phone'] : '';
    }

    static function findById($id = 0)
    {
        $con = Database::newConnection();
        $sql = "select * from users where id = ?";
        $data = [$id];
        $user = $con->fetchOne($sql, $data);
        $con->close();
        if (isset($user)) {
            $_user = new User($user);
            return $_user;
        }
        return null;
    }

    static function findByUsername($username = '')
    {
        $con = Database::getInstance();
        $sql = "select * from users where username = ?";
        $data = [$username];
        $user = $con->fetchOne($sql, $data);
        $con->close();
        if (isset($user)) {
            $user['gender'] = $user['gender'] === 1 ? "male" : "female";
            $_user = new User($user);
            return $_user;
        }
        return null;
    }

    static function auth($username = '', $password = '')
    {
        $con = Database::getInstance();
        $sql = "select * from users where username = ? and password = ?";
        $data = [$username, md5($password)];
        $user = $con->fetchOne($sql, $data);
        if (isset($user)) {
            $_user = new User($user);
            return $_user;
        }
        return null;
    }

    function save()
    {
        $con = Database::getInstance();
        $data = [$this->first_name, $this->last_name, $this->email, $this->phone, $this->username, md5($this->password)];
        $con->queryUpdate("INSERT INTO users (firstname, lastname, email, phone, username, password) values(?, ?, ?, ?, ?, ?)", $data);
    }

    // function update()
    // {
    //     $con = Database::getInstance();
    //     $data = [$this->password, $this->name, $this->id];
    //     $con->queryUpdate("update users set password=?, name=? where id=?", $data);
    // }

    function validate()
    {
        if (!preg_match("/^[a-zA-Z0-9]+$/", $this->username)) {
            return "username only contains a-zA-Z0-9";
        }
        if (empty($this->email) && empty($this->phone)) {
            return "Email and phone empty!";
        }
        if (!empty($this->email)) {
            if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                echo "Mail is not correct";
            }
        }
        if (!empty($this->phone)) {
            if (!preg_match("/^[0-9]{9,12}$/", $this->phone)) {
                echo "Phone is not correct";
            }
        }
        if (empty($this->password)) {
            return "Password empty!";
        }
        if (!preg_match('/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}/', $this->password)) {
            return "Password must have minimum 8 characters, at least one lowercase letter, one uppercase letter, one number. Can have special characters";
        }
        if (empty($this->first_name) || empty($this->last_name)) {
            return "Name empty!";
        }

        return true;
    }

    function __toString()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
