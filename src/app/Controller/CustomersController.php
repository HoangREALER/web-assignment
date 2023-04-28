<?php
namespace App\Controller;

use App\Model\Customer;

class CustomersController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->authentication();
    }

    function get(){
        $items = Customer::findAll();
        $this->data['customers'] = $items;
        $this->view('customers');
    }
}
?>