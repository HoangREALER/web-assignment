<?php
namespace App\Model;

use App\Util\Database\Database;

class Product
{
    public $id;
    public $type;
    public $price;
    public $size;
    public $color;
    public $name = '';
    
    function __construct($params = array())
    {
        $this->id = isset($params['id']) ? $params['id'] : 0;
        $this->price = isset($params['price']) ? $params['price'] : 0;
        $this->type = isset($params['type']) ? $params['type'] : '';
        $this->name = isset($params['name']) ? $params['name'] : '';
        $this->size = isset($params['size']) ? $params['size'] : 0;
        $this->color = isset($params['color']) ? $params['color'] : '';
    }

    static function findById($id = 0)
    {
        $con = Database::newConnection();
        $sql = "select * from products where id=?";
        $data = [$id];
        $user = $con->fetchOne($sql, $data);
        $con->close();
        if(isset($user))
        {
            $_user = new Product($user);
            return $_user;
        }
        return null;
    }

    function __toString()
    {
        return $this->name;
    }
}