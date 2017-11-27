<?php
/**
 * Created by PhpStorm.
 * User: zm
 * Date: 2017/11/12
 * Time: 14:05
 */
namespace Laravue\Web;

use Laravue\Application;

abstract class Controller
{
    public function view($view, $params = [])
    {
        (new Compiler())->compile($view, $params);
    }

    public function toJson($data)
    {
        echo json_encode($data);
    }
}