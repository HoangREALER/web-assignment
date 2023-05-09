<?php
namespace App\Controller;

use App\Model\Comment;

class HomeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->authentication();
    }

    function get(){
        // header("location: index.php?page=login");
        $this->data['home'] = '';
        $this->view('home');
    }
}
?>