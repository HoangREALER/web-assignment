<?php

namespace App\Model;

use App\Util\Database\Database;

class User
{
    public $id;
    public $username;
    public $password;
    public $email;
    public $firstname = '';
    public $lastname = '';
    public $phone = '';
    public $role_id;

    function __construct($params = array())
    {
        $this->id = isset($params['id']) ? $params['id'] : 0;
        $this->username = isset($params['username']) ? $params['username'] : '';
        $this->password = isset($params['password']) ? $params['password'] : '';
        $this->email = isset($params['email']) ? $params['email'] : '';
        $this->firstname = isset($params['firstname']) ? $params['firstname'] : '';
        $this->lastname = isset($params['lastname']) ? $params['lastname'] : '';
        $this->phone = isset($params['phone']) ? $params['phone'] : '';
        $this->role_id = isset($params['role_id']) ? $params['role_id'] : 0;
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
        $data = [$this->firstname, $this->lastname, $this->email, $this->phone, $this->username, md5($this->password), $this->role_id];
        $con->queryUpdate("INSERT INTO users (firstname, lastname, email, phone, username, password, role_id) values(?, ?, ?, ?, ?, ?, ?)", $data);
    }

    function update()
    {
        $con = Database::getInstance();
        $data = [$this->firstname, $this->lastname, $this->email, $this->phone, $this->username, md5($this->password), $this->role_id, $this->id];
        $con->queryUpdate("update users set firstname=?, lastname=?, email=?, phone=?, username=?, password=?, role_id=? where id=?", $data);
    }

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
        if (empty($this->firstname) || empty($this->lastname)) {
            return "Name empty!";
        }

        return true;
    }

    function __toString()
    {
        return $this->firstname . ' ' . $this->lastname;
    }
}
