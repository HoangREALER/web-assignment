<?php
namespace App\Model;

use App\Util\Database\Database;

class Task
{
    public $task_id;
    public $task_name= '';
    public $assigner_id;
    public $assignee_id;
    public $deadline = '';
    public $task_description = '';
    public $task_performed = '';
    public $task_result = '';

    
    function __construct($params = array())
    {
        $this->task_id = isset($params['task_id']) ? $params['task_id'] : 0;
        $this->task_name = isset($params['task_name']) ? $params['task_name'] : '';
        $this->task_description = isset($params['task_description']) ? $params['task_description'] : '';
        $this->assigner_id = isset($params['assigner_id']) ? $params['assigner_id'] : 0;
        $this->assignee_id = isset($params['assignee_id']) ? $params['assignee_id'] : 0;
        $this->deadline = isset($params['deadline']) ? $params['deadline'] : '';
        $this->task_performed = isset($params['task_performed']) ? $params['task_performed'] : '';
        $this->task_result = isset($params['task_result']) ? $params['task_result'] : '';
    }

    static function findById($id = 0)
    {
        $con = Database::newConnection();
        $sql = "select * from tasks where task_id=?";
        $data = [$id];
        $task = $con->fetchOne($sql, $data);
        $con->close();
        if(isset($task))
        {
            $_task = new Task($task);
            return $_task;
        }
        return null;
    }

    static function findByAssigner($id = 0)
    {
        $task = array();
        $con = Database::newConnection();
        $sql = "select * from tasks where assigner_id=?";
        $data = [$id];
        $ress = $con->fetchAll($sql, $data);
        $con->close();
        foreach($ress as $res)
        {
            $task[] = new Task($res);
        }
        return $task;
    }

    static function findByAssignee($id = 0)
    {
        $task = array();
        $con = Database::newConnection();
        $sql = "select * from tasks where assignee_id=?";
        $data = [$id];
        $ress = $con->fetchAll($sql, $data);
        $con->close();
        foreach($ress as $res)
        {
            $task[] = new Task($res);
        }
        return $task;
    }

    static function findByDeadline($deadline = '')
    {
        $task = array();
        $con = Database::newConnection();
        $sql = "select * from tasks where deadline=?";
        $data = [$deadline];
        $ress = $con->fetchAll($sql, $data);
        $con->close();
        foreach($ress as $res)
        {
            $task[] = new Task($res);
        }
        return $task;
    }

    function save() {
        $con = Database::getInstance();
        $data = [$this->task_name, $this->assignee_id, $this->assigner_id, $this->deadline, $this->task_description, $this->task_performed, $this->task_result];
        $con->queryUpdate("INSERT INTO tasks (task_name, assignee_id, assigner_id, deadline, task_description, task_performed, task_result) values(?, ?, ?, ?, ?, ?, ?)", $data);
    }

    function update() {
        $con = Database::getInstance();
        $data = [$this->task_name, $this->assignee_id, $this->assigner_id, $this->deadline, $this->task_description,  $this->task_performed, $this->task_result, $this->task_id];
        $con->queryUpdate("update tasks set task_name=?, assignee_id=?, assigner_id=?, deadline=?, task_description=?, task_performed=?, task_result=? where task_id=?", $data);
    }

    function delete($id = 0) {
        $con = Database::getInstance();
        $data = [$id];
        $con->queryUpdate("DELETE FROM tasks where task_id=?", $data);
    }

    function __toString()
    {
        return $this->task_name;
    }
}