<?php
/**
 * Created by PhpStorm.
 * User: zm
 * Date: 2017/11/12
 * Time: 14:05
 */
namespace App\Controller;

use Laravue\Application;

abstract class Controller
{
    /**
     * @var
     */
    protected $data;
    /**
     * @var
     */

    protected $controller_name;
    /**
     * @var
     */

    protected $view_name;
    /**
     * @var string
     */

    protected $template_dir;

    /**
     * Controller constructor.
     * @param $controller_name
     * @param $view_name
     */
    function __construct($controller_name, $view_name)
    {
        $this->controller_name = $controller_name;
        $this->view_name = $view_name;
        $this->template_dir = Application::getInstance()->base_dir . '/template';
    }

    /**
     * @param $key
     * @param $value
     */
    function assign($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * @param string $file
     */
    function display($file = '')
    {
        if (empty($file))
        {
            $file = strtolower($this->controller_name) . '/' . strtolower($this->view_name) . '.php';
        }

        $path = $this->template_dir . '/' . $file;
        extract($this->data);
        include $path;
    }
}