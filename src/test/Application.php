<?php

require ('./Container.php');

class Application extends Container
{

    protected static $instance;

    static function getInstance()
    {
        if (empty(self::$instance))
        {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
