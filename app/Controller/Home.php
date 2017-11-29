<?php
/**
 * Created by PhpStorm.
 * User: zm
 * Date: 2017/7/12
 * Time: 12:23
 */
namespace App\Controller;

use App\Models\User;

class Home extends Controller
{
    /**
     * @return array
     */
    public function index()
    {
        $user = User::findOne(['id' => 1]);
        //return $this->toJson(['user' => $user]);
        return $this->view('home/index', ['user' => $user]);
    }

    public function welcome()
    {
        return $this->view('welcome');
    }
}