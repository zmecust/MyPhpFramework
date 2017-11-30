<?php

require ('./B.php');

class A
{
    protected $b;

    public function __construct(B $b)
    {
        $this->b = $b;
    }

    public static function get()
    {
        return $this->b->test();
    }
}