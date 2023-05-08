<?php
namespace App\Model;

use App\Util\Database\Database;

class Permission
{
    public $permission_id;
    public $role_id= '';
    public $allowed_function = '';
    
    function __construct($params = array())
    {
        $this->permission_id = isset($params['permission_id']) ? $params['permission_id'] : 0;
        $this->role_id = isset($params['role_id']) ? $params['role_id'] : '';
        $this->allowed_function = isset($params['allowed_function']) ? $params['allowed_function'] : '';
    }

    static function findById($id = 0)
    {
        $con = Database::newConnection();
        $sql = "select * from permission where permission_id=?";
        $data = [$id];
        $perm = $con->fetchOne($sql, $data);
        $con->close();
        if(isset($perm))
        {
            $_perm = new Role($perm);
            return $_perm;
        }
        return null;
    }

    static function findByRoleId($id = 0)
    {
        $permission = array();
        $con = Database::newConnection();
        $sql = "select * from permission where role_id=?";
        $data = [$id];
        $ress = $con->fetchAll($sql, $data);
        $con->close();
        foreach($ress as $res)
        {
            $permission[] = new Permission($res);
        }
        return $permission;
    }

    static function findByFunction($function = '')
    {
        $permission = array();
        $con = Database::newConnection();
        $sql = "select * from permission where allowed_function=?";
        $data = [$function];
        $ress = $con->fetchAll($sql, $data);
        $con->close();
        foreach($ress as $res)
        {
            $permission[] = new Permission($res);
        }
        return $permission;
    }

    function save() {
        $con = Database::getInstance();
        $data = [$this->role_id, $this->allowed_function];
        $con->queryUpdate("INSERT INTO roles (role_id, allowed_function) values(?, ?)", $data);
    }

    function update() {
        $con = Database::getInstance();
        $data = [$this->role_id, $this->allowed_function, $this->permission_id];
        $con->queryUpdate("update roles set role_name=?, role_des=? where permission_id=?", $data);
    }

    function delete($id = 0) {
        $con = Database::getInstance();
        $data = [$id];
        $con->queryUpdate("DELETE FROM permission where permission_id=?", $data);
    }

    function __toString()
    {
        return $this->allowed_function;
    }
}