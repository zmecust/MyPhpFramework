<?php
/**
 * Created by PhpStorm.
 * User: zm
 * Date: 2017/7/12
 * Time: 17:24
 */
namespace App\Middleware;

class CheckLogin
{
    /**
     * @param $controller
     */
    function beforeRequest($controller = null)
    {
        session_start();
        if (empty($_SESSION['isLogin']))
        {
            header('Location: /MyPhpFramework/public/login/index/');
            exit;
        }
    }

    /**
     * @param null $data
     */
    function afterRequest($data = null)
    {
        //
    }
}