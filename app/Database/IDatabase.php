<?php
/**
 * Created by PhpStorm.
 * User: zm
 * Date: 2017/7/12
 * Time: 14:38
 */
namespace App\Database;

interface IDatabase
{
    /**
     * @param $host
     * @param $user
     * @param $password
     * @param $database
     * @return mixed
     */
    public function connect($host, $user, $password, $database);

    /**
     * @param $sql
     * @return mixed
     */
    public function query($sql);

    /**
     * @return mixed
     */
    public function close();
}