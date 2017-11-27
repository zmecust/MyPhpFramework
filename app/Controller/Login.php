<?php
/**
 * Created by PhpStorm.
 * User: zm
 * Date: 2017/11/12
 * Time: 17:28
 */
namespace App\Controller;

class Login extends Controller
{
    public function index()
    {
        return $this->view('user/login');
    }
}