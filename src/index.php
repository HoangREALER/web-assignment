<?php

require_once 'config.php';
require_once 'vendor/autoload.php';
// use App\Core\FileSessionHandler;

// $handler = new FileSessionHandler();
// session_set_save_handler($handler, true);
session_start();

function customError($errno, $errstr) {
    echo json_encode(array("success" => false, "error" => "Yup, some error occurs, silly dev."));
}
  
//set error handler
set_error_handler("customError");
  
function customException($exception) {
    echo json_encode(array("success" => false, "error" => "Yup, some error occurs, silly dev."));
}
 
set_exception_handler('customException');

use App\Core\Application;

Application::execute();