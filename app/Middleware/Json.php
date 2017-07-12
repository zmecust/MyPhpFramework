<?php
/**
 * Created by PhpStorm.
 * User: zm
 * Date: 2017/7/12
 * Time: 13:16
 */
namespace App\Middleware;

class Json
{
    /**
     * @param null $controller
     */
    function beforeRequest($controller = null)
    {
        //
    }

    /**
     * @param $data
     */
    function afterRequest($data)
    {
        echo json_encode($data);
    }
}