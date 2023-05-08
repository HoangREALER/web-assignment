<?php
namespace App;

use App\Controller\BranchController;
use App\Core\Route;
class Router
{
    static function route(){
        //default error
        Route::get('404', 'NotFoundController@get');
        Route::get('405', 'MethodNotAllowController@get');
        //add route here
        Route::get('home', 'HomeController@get');
        Route::get('logout', 'LoginController@logout');
        //login
        Route::get('login', 'LoginController@get');
        Route::post('login', 'LoginController@post');
        // logout
        Route::get('logout', 'LoginController@logout');
        // Register
        Route::get('register', 'RegisterController@get');
        Route::post('register', 'RegisterController@post');
        // Task
        Route::get('task', 'TaskController@get');
        Route::post('review', 'TaskController@reviewTask');
        Route::post('assign', 'TaskController@assignTask');
        Route::post('submit', 'TaskController@submit');
    }
}
?>