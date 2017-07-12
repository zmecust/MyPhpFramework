<?php
/**
 * Created by PhpStorm.
 * User: zm
 * Date: 2017/7/12
 * Time: 12:23
 */
namespace App\Controller;

use App\Factory;
use Carbon\Carbon;

class Home extends Controller
{
    /**
     * @return array
     */
    public function index()
    {
        $user = Factory::getModel('User', 1);

        $user->name = 'zhangmin';
        $user->email = 'root@laravue.org';

        return [
            'user' => $user->name,
            'msg' => 'Welcome To ZMECUST\'s Home',
            'time' => Carbon::now(),
        ];
    }
}