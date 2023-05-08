<?php
namespace App\Model;

use App\Util\Database\Database;
use Twig\Node\Expression\MethodCallExpression;

class Message
{
    public $message_id;
    public $sender_id;
    public $receiver_id;
    public $message = '';

    
    function __construct($params = array())
    {
        $this->message_id = isset($params['message_id']) ? $params['message_id'] : 0;
        $this->message = isset($params['message']) ? $params['message'] : '';
        $this->sender_id = isset($params['sender_id']) ? $params['sender_id'] : 0;
        $this->receiver_id = isset($params['receiver_id']) ? $params['receiver_id'] : 0;
    }

    static function findById($id = 0)
    {
        $con = Database::newConnection();
        $sql = "select * from message where message_id=?";
        $data = [$id];
        $msg = $con->fetchOne($sql, $data);
        $con->close();
        if(isset($msg))
        {
            $_msg = new Message($msg);
            return $_msg;
        }
        return null;
    }

    static function findBySender($id = 0)
    {
        $msg = array();
        $con = Database::newConnection();
        $sql = "select * from message where sender_id=?";
        $data = [$id];
        $ress = $con->fetchAll($sql, $data);
        $con->close();
        foreach($ress as $res)
        {
            $msg[] = new Message($res);
        }
        return $msg;
    }

    static function findByReceiver($id = 0)
    {
        $msg = array();
        $con = Database::newConnection();
        $sql = "select * from message where receiver_id=?";
        $data = [$id];
        $ress = $con->fetchAll($sql, $data);
        $con->close();
        foreach($ress as $res)
        {
            $msg[] = new Message($res);
        }
        return $msg;
    }

    function save() {
        $con = Database::getInstance();
        $data = [$this->receiver_id, $this->sender_id, $this->message];
        $con->queryUpdate("INSERT INTO message (receiver_id, sender_id, message) values(?, ?, ?)", $data);
    }

    function update() {
        $con = Database::getInstance();
        $data = [$this->receiver_id, $this->sender_id, $this->message, $this->message_id];
        $con->queryUpdate("update message set receiver_id=?, sender_id=?, message=? where permission_id=?", $data);
    }

    function delete($id = 0) {
        $con = Database::getInstance();
        $data = [$id];
        $con->queryUpdate("DELETE FROM message where message_id=?", $data);
    }

    function __toString()
    {
        return $this->message;
    }
}