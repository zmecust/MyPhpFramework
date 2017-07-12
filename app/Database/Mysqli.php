<?php
/**
 * Created by PhpStorm.
 * User: zm
 * Date: 2017/7/12
 * Time: 14:40
 */
namespace App\Database;

class Mysqli implements IDatabase
{
    /**
     * @var
     */
    protected $conn;

    /**
     * @param $host
     * @param $user
     * @param $password
     * @param $database
     */
    function connect($host, $user, $password, $database)
    {
        $conn = mysqli_connect($host, $user, $password, $database);
        $this->conn = $conn;
    }

    /**
     * @param $sql
     * @return bool|\mysqli_result
     */
    function query($sql)
    {
        return mysqli_query($this->conn, $sql);
    }

    /**
     *
     */
    function close()
    {
        mysqli_close($this->conn);
    }
}