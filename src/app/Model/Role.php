<?php
namespace App\Model;

use App\Util\Database\Database;

class Role
{
    public $role_id;
    public $role_name= '';
    public $role_des = '';
    
    function __construct($params = array())
    {
        $this->role_id = isset($params['id']) ? $params['id'] : 0;
        $this->role_name = isset($params['name']) ? $params['name'] : '';
        $this->role_des = isset($params['size']) ? $params['size'] : 0;
    }

    static function findById($id = 0)
    {
        $con = Database::newConnection();
        $sql = "select * from roles where role_id=?";
        $data = [$id];
        $role = $con->fetchOne($sql, $data);
        $con->close();
        if(isset($role))
        {
            $_role = new Role($role);
            return $_role;
        }
        return null;
    }
    
    function update() {
        $con = Database::getInstance();
        $data = [$this->role_name, $this->role_des, $this->role_id];
        $con->queryUpdate("update roles set role_name=?, role_des=? where role_id=?", $data);
    }


    function save() {
        $con = Database::getInstance();
        $data = [$this->role_name, $this->role_des];
        $con->queryUpdate("INSERT INTO roles (role_name, role_des) values(?, ?)", $data);
    }

    static function delete($id = 0) {
        $con = Database::getInstance();
        $data = [$id];
        $con->queryUpdate("DELETE FROM roles where role_id=?", $data);
    }

    function __toString()
    {
        return $this->role_name;
    }
}