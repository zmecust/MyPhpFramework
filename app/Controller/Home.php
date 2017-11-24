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
        return [ 'user' => $user ];
    }

    public function welcome()
    {
        include __DIR__ . '/../../template/welcome.php';
    }
}