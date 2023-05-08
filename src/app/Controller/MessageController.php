<?php

namespace App\Controller;

use App\Model\User;
use App\Model\Role;
use App\Model\Permission;
use App\Model\Task;
use App\Model\Message;

class MessageController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->authentication();
    }
    function get() // GET
    {
        // TODO: Get all the message that being sent to the user
        $message = Message::findByReceiver($this->auth()->id);
        $this->data['message_id'] = $this->auth()->message_id;
        $this->data['message'] = $this->auth()->message;
        $this->data['sender_id'] = $this->auth()->sender_id;
        $this->data['receiver_id'] = $this->auth()->receiver_id;
        $this->view('message');

    }

    function post() // POST
    {
        $data = array();
        $data['message'] = isset($_POST['message']) ? $_POST['message'] : '';
        $data['receiver_id'] = isset($_POST['receiver_id']) ? $_POST['receiver_id'] : '';
        $data['sender_id'] = $this->auth()->id;
        $message = new Message($data);

        if (User::findById($data['receiver_id']) == null) {
            echo json_encode(array('success' => false, 'error' => 'Receiver does not exist'));
            return true;
        } else {
            $message->save();
            echo json_encode(array('success' => true));
            return false;
        }
    }
}
