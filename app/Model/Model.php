<?php
/**
 * Created by PhpStorm.
 * User: zm
 * Date: 2017/7/12
 * Time: 16:49
 */
namespace App\Model;

abstract class Model
{
    /**
     * @var
     */
    protected $id;
    /**
     * @var
     */
    protected $data;
    /**
     * @var
     */
    protected $db;
    /**
     * @var bool
     */
    protected $change = false;

    /**
     * Model constructor.
     * @param $database
     * @param $id
     */
    function __construct($database, $id)
    {
        $this->db = Factory::getDatabase();
        $res = $this->db->query("select * from $database where id = $id limit 1");
        $this->data = $res->fetch_assoc();
        $this->id = $id;
    }

    /**
     * @param $key
     * @return mixed
     */
    function __get($key)
    {
        if (isset($this->data[$key]))
        {
            return $this->data[$key];
        }
    }

    /**
     * @param $key
     * @param $value
     */
    function __set($key, $value)
    {
        $this->data[$key] = $value;
        $this->change = true;
    }

    /**
     *
     */
    function __destruct()
    {
        if ($this->change)
        {
            foreach ($this->data as $k => $v)
            {
                $fields[] = "$k = '{$v}'";
            }
            $this->db->query(" update user set " . implode(', ', $fields) . " where
            id = {$this->id} limit 1");
        }
    }
}