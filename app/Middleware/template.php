<?php
/**
 * Created by PhpStorm.
 * User: zm
 * Date: 2017/7/12
 * Time: 13:42
 */
namespace App\Middleware;

use App\Controller\Controller;

class Template
{
    /**
     * @var
     */
    protected $controller;

    /**
     * @param Controller $controller
     */
    function beforeRequest(Controller $controller)
    {
        $this->controller = $controller;
    }

    /**
     * @param $data
     */
    function afterRequest($data)
    {
        foreach($data as $k => $v)
        {
            $this->controller->assign($k, $v);
        }
        $this->controller->display();
    }
}